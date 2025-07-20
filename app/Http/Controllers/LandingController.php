<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function store(Request $request)
    {
        
        Log::info('Reservation Request Received', [
            'request_data' => $request->all(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            
            $validatedData = $request->validate([
                'number_of_guests' => 'required|integer|min:1|max:9',
                'reservation_date' => 'required|date|after_or_equal:today',
                'reservation_time' => 'required|string',
                'guest_gender' => 'required|string|in:Mr.,Mrs.,Ms.,Mx.',
                'guest_first_name' => 'required|string|max:255',
                'guest_last_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
                'guest_phone_number' => 'required|string|max:20',
                'agreed_dietary_policy' => 'required|boolean',
                'receive_promotions' => 'nullable|boolean',
                'personalized_recommendations' => 'nullable|boolean',
                'agreed_terms' => 'required|accepted',
                'agreed_cancellation_policy' => 'required|boolean',
                'payment_method' => 'required|string|in:credit_card,debit_card,cash',
                'voucher_code' => 'nullable|string|max:50',
            ]);

            Log::info('Data Validation Passed', ['validated_data' => $validatedData]);

            
            $user = null;

            
            Log::debug('Checking for previous reservations with phone: ' . $validatedData['guest_phone_number']);
            $previousReservation = Reservation::where('guest_phone_number', $validatedData['guest_phone_number'])->first();

            if ($previousReservation) {
                Log::info('Previous reservation found', ['reservation_id' => $previousReservation->id]);
            } else {
                Log::info('No previous reservation found - new customer');
            }

            
            if (!$previousReservation) {
                Log::debug('Creating new user account');

                try {
                    $user = User::create([
                        'name' => $validatedData['guest_first_name'] . ' ' . $validatedData['guest_last_name'],
                        'email' => $validatedData['guest_email'],
                        'password' => Hash::make('password'),
                        'role_id' => Role::where('name', 'user')->first()->id,
                    ]);

                    Log::info('New user created successfully', ['user_id' => $user->id]);
                } catch (\Exception $e) {
                    Log::error('User creation failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'input_data' => [
                            'name' => $validatedData['guest_first_name'] . ' ' . $validatedData['guest_last_name'],
                            'email' => $validatedData['guest_email']
                        ]
                    ]);
                    throw $e;
                }
            } else {
                
                Log::debug('Looking for existing user with ID: ' . $previousReservation->user_id);
                $user = User::find($previousReservation->user_id);

                if (!$user) {
                    Log::error('User account not found for existing reservation', [
                        'reservation_id' => $previousReservation->id,
                        'expected_user_id' => $previousReservation->user_id
                    ]);
                }
            }

            
            if ($user) {
                Auth::login($user);
                Log::info('User authenticated', ['user_id' => $user->id]);
            } else {
                Log::error('User authentication failed - no user account available');
                return response()->json([
                    'success' => false,
                    'message' => 'User account not found. Please try again or contact support.'
                ], 404);
            }

            
            Log::debug('Creating new reservation record');
            try {
                $reservation = Reservation::create([
                    'user_id' => auth()->id(),
                    'reservation_date' => $validatedData['reservation_date'],
                    'reservation_time' => $validatedData['reservation_time'],
                    'number_of_guests' => $validatedData['number_of_guests'],
                    'status' => 'pending',
                    'guest_gender' => $validatedData['guest_gender'],
                    'guest_first_name' => $validatedData['guest_first_name'],
                    'guest_last_name' => $validatedData['guest_last_name'],
                    'guest_email' => $validatedData['guest_email'],
                    'guest_phone_number' => $validatedData['guest_phone_number'],
                    'agreed_dietary_policy' => $validatedData['agreed_dietary_policy'],
                    'receive_promotions' => $validatedData['receive_promotions'] ?? false,
                    'personalized_recommendations' => $validatedData['personalized_recommendations'] ?? false,
                    'agreed_terms' => $validatedData['agreed_terms'],
                    'agreed_cancellation_policy' => $validatedData['agreed_cancellation_policy'],
                    'payment_method' => $validatedData['payment_method'],
                    'voucher_code' => $validatedData['voucher_code'],
                    'payment_status' => 'pending',
                ]);

                Log::info('Reservation created successfully', ['reservation_id' => $reservation->id]);

                
                return redirect()->route('home')
                    ->with('success', 'Reservasi Anda berhasil!')
                    ->with('account_info', [
                        'email' => $validatedData['guest_email'],
                        'password' => 'password'
                    ]);
            } catch (\Exception $e) {
                Log::error('Reservation creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'input_data' => $validatedData,
                    'user_id' => auth()->id()
                ]);

                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Reservation processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create reservation. Please try again later.',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
