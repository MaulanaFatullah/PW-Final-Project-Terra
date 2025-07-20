<style>
    .btn-next {
        background-color: #723828;
        color: white;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-next:hover {
        background-color: #3d1a12;
        color: white;
    }

    .btn-back {
        border: 1px solid #723828;
        background-color: #72382800;
        color: #723828;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #3d1a12;
        color: white;
    }

    .btn-reservation {
        border: 1px solid #fffb00;
        background-color: #fffb00;
        color: #723828;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-reservation:hover {
        background-color: #ffbf00;
        color: #723828;
    }
</style>

<form id="reservationForm" method="POST" action="/reservation_landing">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 shadow overflow-hidden">
                <div class="bg-choco-800 text-white p-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/logo/logo-terra.png') }}" alt="Restaurant logo"
                                class="rounded-circle" width="60" height="60">
                            <div>
                                <h5 class="mb-0 fw-bold">Restaurant Terra</h5>
                                <small>Wed-Thu: 6:30 - 10:30pm (Last Seating: 7:30pm)</small><br>
                                <small>Fri-Sun: 12:00 – 2:30pm, 6:30 – 10:30pm</small><br>
                                <small class="fst-italic">Closed Monday and Tuesday</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <div class="p-4 bg-light">


                    <div class="mb-3">
                        <label class="form-label">Seats</label>
                        <select class="form-select" name="number_of_guests" required>
                            <option value="1">1 Adult</option>
                            <option value="2" selected>2 Adults</option>
                            <option value="3">3 Adults</option>
                            <option value="4">4 Adults</option>
                            <option value="5">5 Adults</option>
                            <option value="6">6 Adults</option>
                            <option value="7">7 Adults</option>
                            <option value="8">8 Adults</option>
                            <option value="9">9 Adults</option>
                        </select>
                    </div>


                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="reservation_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Time</label>
                            <select class="form-select" name="reservation_time" required>
                                <option value="8:00">8:00 AM</option>
                                <option value="9:00">9:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="13:00">1:00 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="18:00">6:00 PM</option>
                                <option value="19:00">7:00 PM</option>
                            </select>
                        </div>
                    </div>


                    <div class="bg-white p-3 mt-4 border rounded text-sm">
                        <p class="fw-bold mb-1">Please allow 3 hours for the full Terra experience.</p>
                        <p class="mb-1"><strong>Valentine's Day, Christmas Eve, Christmas Day, and New Year's
                                Eve:</strong>
                            Kindly note that any reservation made on such dates is non-negotiable and non-refundable.
                        </p>
                        <p>For groups of 5 pax and above, reservations are final after which no changes are allowed.</p>
                    </div>


                    <div class="form-check my-3">
                        <input class="form-check-input" type="hidden" name="agreed_terms" value="0">
                        <input class="form-check-input" type="checkbox" id="agreeCheckStep1" name="agreed_terms"
                            value="1" required>
                        <label class="form-check-label" for="agreeCheckStep1">
                            Saya telah membaca dan menyetujui syarat dan ketentuan di atas.
                        </label>
                    </div>


                    <button type="button" class="btn btn-next w-100" id="nextToStep2">
                        Next →
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="guestInfoModal" tabindex="-1" aria-labelledby="Step2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 shadow overflow-hidden">
                <div class="bg-choco-800 text-white p-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/logo/logo-terra.png') }}" alt="Restaurant logo"
                                class="rounded-circle" width="60" height="60">
                            <div>
                                <h5 class="mb-0 fw-bold">Restaurant Terra</h5>
                                <small>Wed-Thu: 6:30 - 10:30pm (Last Seating: 7:30pm)</small><br>
                                <small>Fri-Sun: 12:00 – 2:30pm, 6:30 – 10:30pm</small><br>
                                <small class="fst-italic">Closed Monday and Tuesday</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body">

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="guestGender">Gender</label>
                        <div class="position-relative">
                            <i
                                class="bi bi-person-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                            <select class="form-select ps-5" id="guestGender" name="guest_gender" required>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Mr." selected>Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Mx.">Mx.</option>
                            </select>
                        </div>
                    </div>


                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="guestFirstName" class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="guestFirstName"
                                    name="guest_first_name" placeholder="First" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="guestLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="guestLastName" name="guest_last_name"
                                placeholder="Last" required>
                        </div>
                    </div>


                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="guestEmail" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" class="form-control" id="guestEmail" name="guest_email"
                                    placeholder="xxx@gmail.com" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="guestPhoneNumber" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="tel" class="form-control" id="guestPhoneNumber"
                                    name="guest_phone_number" placeholder="08xxxxxxx" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="agreedDietaryPolicy"
                            name="agreed_dietary_policy" value="1" required>
                        <label class="form-check-label" for="agreedDietaryPolicy">
                            I have read and agree to the Dietary Requirement Policy.
                        </label>
                    </div>

                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="dietaryDisclaimer"
                            name="dietary_disclaimer" value="1" required>
                        <label class="form-check-label" for="dietaryDisclaimer">
                            <b>Restaurant may not accommodate vegetarian, vegan, celiac, or allergies to
                                dairy/gluten/etc.</b>
                        </label>
                    </div>


                    <div class="mb-3">
                        <label for="notes" class="form-label">Message (Max 85 characters)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-journal"></i></span>
                            <textarea class="form-control" id="notes" name="notes" maxlength="85" rows="3"
                                placeholder="Enter your message..."></textarea>
                        </div>
                    </div>


                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="payment" class="form-label">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="creditCard"
                                    value="credit_card" required>
                                <label class="form-check-label d-flex align-items-center gap-2" for="creditCard">
                                    Credit Card
                                    <i class="bi bi-credit-card text-secondary"></i>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="debitCard"
                                    value="debit_card" required>
                                <label class="form-check-label d-flex align-items-center gap-2" for="debitCard">
                                    Debit Card
                                    <i class="bi bi-credit-card-2-front text-secondary"></i>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cash"
                                    value="cash" required>
                                <label class="form-check-label d-flex align-items-center gap-2" for="cash">
                                    Cash
                                    <i class="bi bi-cash-stack text-success"></i>
                                </label>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="voucherCode" class="form-label">Voucher Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-ticket-fill"></i></span>
                                <input type="text" class="form-control" id="voucherCode" name="voucher_code"
                                    placeholder="T3RR4">
                            </div>
                        </div>
                    </div>

                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="receivePromotions"
                            name="receive_promotions" value="1">
                        <label class="form-check-label" for="receivePromotions">
                            I'd love to get updates and promotions.
                        </label>
                    </div>

                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="personalizedRecommendations"
                            name="personalized_recommendations" value="1">
                        <label class="form-check-label" for="personalizedRecommendations">
                            I want personalized dining recommendations.
                        </label>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 pe-md-1">
                            <button type="button" class="btn btn-back w-100" id="backToStep1">
                                ← Back
                            </button>
                        </div>
                        <div class="col-md-6 ps-md-1">
                            <button type="button" class="btn btn-next w-100" id="nextToStep3">
                                Next →
                            </button>
                        </div>
                    </div>

                    <p class="text-center small fst-italic mt-3">By confirming this reservation, I agree to Chope's
                        <span class="text-info">Privacy Policy and Terms & Conditions.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="preferencesModal" tabindex="-1" aria-labelledby="Step3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-4 shadow overflow-hidden">
                <div class="bg-choco-800 text-white p-4">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('images/logo/logo-terra.png') }}" alt="Restaurant logo"
                                class="rounded-circle" width="60" height="60">
                            <div>
                                <h5 class="mb-0 fw-bold">Restaurant Terra</h5>
                                <small>Wed-Thu: 6:30 - 10:30pm (Last Seating: 7:30pm)</small><br>
                                <small>Fri-Sun: 12:00 – 2:30pm, 6:30 – 10:30pm</small><br>
                                <small class="fst-italic">Closed Monday and Tuesday</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>


                <div class="modal-body">

                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="agreedCancellationPolicy"
                            name="agreed_cancellation_policy" value="1" required>
                        <label class="form-check-label" for="agreedCancellationPolicy">
                            <b>By continuing, I agree with the restaurant's Cancellation Policy:</b>
                            Kindly provide your payment details on this secure platform powered by Stripe. You are able
                            to
                            check out as a guest if you do not have a Stripe account.

                            <b>Cancellation/Rescheduling Policy:</b>
                            No show or last-minute cancellation/rescheduling before the reservation will be subject to a
                            cancellation fee of the total guaranteed amount unless otherwise discussed and agreed upon.

                            Cancellations/Rescheduling of reservations for all party sizes must be done more than 72
                            hours
                            prior to the date of the reservation to avoid incurring a cancellation fee.

                            The cancellation fee reflects the cost of food, drink and staffing incurred by us in
                            anticipation of the booking and lost revenue from the empty table.

                            Our dress code is smart casual, we kindly request all gentlemen to refrain from wearing open
                            footwear and shorts.
                        </label>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 pe-md-1">
                            <button type="button" class="btn btn-back w-100" id="backToStep2">
                                ← Back
                            </button>
                        </div>
                        <div class="col-md-6 ps-md-1">
                            <button type="button" class="btn btn-next w-100" id="nextToStep4">
                                Authorize Hold of IDR 250,000
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="Step4Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="Step4Label">Thank You!</h5>
                    <button type="submit" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Your reservation has been confirmed successfully.</p>
                    <p>Please check your email for confirmation details.</p>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        function showModal(modalId) {

            document.querySelectorAll('.modal').forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });


            setTimeout(() => {
                const targetModal = new bootstrap.Modal(document.getElementById(modalId));
                targetModal.show();
            }, 300);
        }

        function updateSummary() {
            const summary = document.getElementById('reservationSummary');
            if (summary) {
                const guests = document.querySelector('[name="number_of_guests"]').value;
                const date = document.querySelector('[name="reservation_date"]').value;
                const time = document.querySelector('[name="reservation_time"]').value;
                const firstName = document.querySelector('[name="guest_first_name"]').value;
                const lastName = document.querySelector('[name="guest_last_name"]').value;
                const email = document.querySelector('[name="guest_email"]').value;

                summary.innerHTML = `
                        <p><strong>Guests:</strong> ${guests} Adult${guests > 1 ? 's' : ''}</p>
                        <p><strong>Date:</strong> ${date}</p>
                        <p><strong>Time:</strong> ${time}</p>
                        <p><strong>Name:</strong> ${firstName} ${lastName}</p>
                        <p><strong>Email:</strong> ${email}</p>
                    `;
            }
        }


        document.getElementById('nextToStep2').addEventListener('click', function() {
            const checkbox = document.getElementById('agreeCheckStep1');
            if (!checkbox.checked) {
                alert('Please agree to the terms and conditions.');
                return;
            }
            showModal('guestInfoModal');
        });


        document.getElementById('nextToStep3').addEventListener('click', function() {
            const requiredFields = ['guest_gender', 'guest_first_name', 'guest_last_name',
                'guest_email', 'guest_phone_number'
            ];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields.');
                return;
            }

            showModal('preferencesModal');
        });


        document.getElementById('nextToStep4').addEventListener('click', function() {
            const dietary = document.getElementById('agreedDietaryPolicy');
            const terms = document.getElementById('agreeCheckStep1');
            const cancellation = document.getElementById('agreedCancellationPolicy');

            if (!dietary.checked || !terms.checked || !cancellation.checked) {
                alert('Please agree to all required policies.');
                return;
            }

            updateSummary();
            showModal('paymentModal');
        });


        document.getElementById('backToStep1').addEventListener('click', function() {
            showModal('reservationModal');
        });

        document.getElementById('backToStep2').addEventListener('click', function() {
            showModal('guestInfoModal');
        });

        document.getElementById('backToStep3').addEventListener('click', function() {
            showModal('preferencesModal');
        });


        document.getElementById('reservationForm').addEventListener('submit', function(e) {
            e.preventDefault();


            const agreeCheckbox = document.getElementById('agreeCheckStep1');
            if (!agreeCheckbox.checked) {

                document.querySelector('input[name="agreed_terms"][type="hidden"]').value = '0';
                agreeCheckbox.checked = false;
            } else {

                document.querySelector('input[name="agreed_terms"][type="hidden"]').value = '1';
            }

            const formData = new FormData(this);

            fetch('/reservation_landing', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            let errorMessage = 'Terjadi kesalahan tidak diketahui.';

                            if (response.status === 422) {

                                errorMessage =
                                    'Validasi gagal. Silakan periksa input Anda.';


                                if (data.errors && data.errors.agreed_terms) {
                                    errorMessage += '\n- ' + data.errors.agreed_terms.join(
                                        '\n- ');
                                }


                                for (const field in data.errors) {
                                    if (field !== 'agreed_terms') {
                                        errorMessage += '\n- ' + data.errors[field].join(
                                            '\n- ');
                                    }
                                }
                            } else if (data.message) {
                                errorMessage = data.message;
                            }

                            throw new Error(errorMessage);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Reservasi berhasil dikonfirmasi!');

                        document.querySelectorAll('.modal').forEach(modal => {
                            const modalInstance = bootstrap.Modal.getInstance(modal);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        });
                        this.reset();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);


                    if (error.message.includes('agreed_terms')) {
                        const checkboxContainer = document.getElementById('agreeCheckStep1')
                            .closest('.form-check');
                        checkboxContainer.classList.add('is-invalid');


                        let errorElement = checkboxContainer.querySelector('.invalid-feedback');
                        if (!errorElement) {
                            errorElement = document.createElement('div');
                            errorElement.className = 'invalid-feedback';
                            checkboxContainer.appendChild(errorElement);
                        }
                        errorElement.textContent = 'Anda harus menyetujui syarat dan ketentuan.';
                    }
                });
        });


        const dateInput = document.querySelector('[name="reservation_date"]');
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }
    });
</script>
