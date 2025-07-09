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

<!-- Modal 1 -->
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

            <form class="p-4 bg-light">
                {{-- gender --}}
                <div class="mb-3">
                    <label class="form-label">Seats</label>
                    <select class="form-select">
                        <option>1 Adult</option>
                        <option selected>2 Adults</option>
                        <option>3 Adults</option>
                        <option>5 Adults</option>
                        <option>6 Adults</option>
                        <option>7 Adults</option>
                        <option>8 Adults</option>
                        <option>9 Adults</option>
                    </select>
                </div>

                {{-- tanggal dan waktu --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Time</label>
                        <select class="form-select">
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

                {{-- info box --}}
                <div class="bg-white p-3 mt-4 border rounded text-sm">
                    <p class="fw-bold mb-1">Please allow 3 hours for the full Terra experience.</p>
                    <p class="mb-1"><strong>Valentine’s Day, Christmas Eve, Christmas Day, and New Year’s
                            Eve:</strong>
                        Kindly note that any reservation made on such dates is non-negotiable and non-refundable.</p>
                    <p>For groups of 5 pax and above, reservations are final after which no changes are allowed.</p>
                </div>

                {{-- terms --}}
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="agreeCheckStep1">
                    <label class="form-check-label" for="agreeCheckStep1">
                        I have read and agree to the above terms and conditions.
                    </label>
                </div>

                {{-- next button --}}
                <button type="button" class="btn btn-next w-100" id="nextToStep2">
                    Next →
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2 -->
<div class="modal fade" id="Step2" tabindex="-1" aria-labelledby="Step2Label" aria-hidden="true">
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
                {{-- gender --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gender</label>
                    <div class="position-relative">
                        <i
                            class="bi bi-person-fill position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                        <select class="form-select ps-5">
                            <option>Mrs.</option>
                            <option selected>Mr.</option>
                        </select>
                    </div>
                </div>

                {{-- first name, last name --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" id="firstName" placeholder="First">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Last">
                    </div>
                </div>

                {{-- email, phone number --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" id="email" placeholder="xxx@gmail.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="telp" class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" class="form-control" id="telp" placeholder="08xxxxxxx">
                        </div>
                    </div>
                </div>

                <!-- Checkboxes with unique IDs -->
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="dietCheck1">
                    <label class="form-check-label" for="dietCheck1">
                        I have read and agree to the Dietary Requirement Policy.
                    </label>
                </div>

                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="dietCheck2">
                    <label class="form-check-label" for="dietCheck2">
                        <b>Restaurant may not accommodate vegetarian, vegan, celiac, or allergies to
                            dairy/gluten/etc.</b>
                    </label>
                </div>

                {{-- message --}}
                <div class="mb-3">
                    <label for="message" class="form-label">Message (Max 85 characters)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-journal"></i></span>
                        <textarea class="form-control" id="message" maxlength="85" rows="3" placeholder="Enter your message..."></textarea>
                    </div>
                </div>

                {{-- payment method --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="payment" class="form-label">Payment Method</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard"
                                value="credit">
                            <label class="form-check-label d-flex align-items-center gap-2" for="creditCard">
                                Credit Card
                                <i class="bi bi-credit-card text-secondary"></i>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="paypal"
                                value="paypal">
                            <label class="form-check-label d-flex align-items-center gap-2" for="paypal">
                                PayPal
                                <i class="bi bi-paypal text-primary"></i>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="bank"
                                value="bank">
                            <label class="form-check-label d-flex align-items-center gap-2" for="bank">
                                Bank Transfer
                                <i class="bi bi-bank text-success"></i>
                            </label>
                        </div>
                    </div>

                    {{-- voucher code --}}
                    <div class="col-md-6">
                        <label for="voucher" class="form-label">Voucher Code</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-ticket-fill"></i></span>
                            <input type="text" class="form-control" id="voucher" placeholder="T3RR4">
                        </div>
                    </div>
                </div>


                <!-- Terms -->
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="termsCheck">
                    <label class="form-check-label" for="termsCheck">
                        I agree to the terms and conditions.
                    </label>
                </div>

                <!-- Promotions -->
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="promoCheck">
                    <label class="form-check-label" for="promoCheck">
                        I’d love to get updates and promotions.
                    </label>
                </div>

                <!-- Recommendations -->
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="recommendCheck">
                    <label class="form-check-label" for="recommendCheck">
                        I want personalized dining recommendations.
                    </label>
                </div>

                <!-- Back and Next Buttons -->
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

                <p class="text-center small fst-italic mt-3">By confirming this reservation, I aggree to Chope's
                    <span class="text-info">Privacy Policy and Terms & Conditions.</span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Modal 3 --}}
<div class="modal fade" id="Step3" tabindex="-1" aria-labelledby="Step3Label" aria-hidden="true">
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

            {{-- Body --}}
            <div class="modal-body">
                {{-- cancellation policy --}}
                <div class="form-check my-3">
                    <input class="form-check-input" type="checkbox" id="lastCheck">
                    <label class="form-check-label" for="lastCheck">
                        <b>By continuing, I agree with the restaurant's Cancellation Policy:</b>
                        Kindly provide your payment details on this secure platform powered by Stripe. You are able to
                        check out as a guest if you do not have a Stripe account.

                        <b>Cancellation/Rescheduling Policy:</b>
                        No show or last-minute cancellation/rescheduling before the reservation will be subject to a
                        cancellation fee of the total guaranteed amount unless otherwise discussed and agreed upon.

                        Cancellations/Rescheduling of reservations for all party sizes must be done more than 72 hours
                        prior to the date of the reservation to avoid incurring a cancellation fee.

                        The cancellation fee reflects the cost of food, drink and staffing incurred by us in
                        anticipation of the booking and lost revenue from the empty table.

                        Our dress code is smart casual, we kindly request all gentlemen to refrain from wearing open
                        footwear and shorts.
                    </label>
                </div>

                <!-- Back and Next Buttons -->
                <div class="row mt-4">
                    <div class="col-md-6 pe-md-1">
                        <button type="button" class="btn btn-back w-100" id="backToStep2">
                            ← Back
                        </button>
                    </div>
                    <div class="col-md-6 ps-md-1">
                        <button type="button" class="btn btn-reservation w-100" id="reservation">
                            Authorize Hold of IDR 250,000
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal 4 --}}
<div class="modal fade" id="Step4" tabindex="-1" aria-labelledby="Step4Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="Step4Label">Thank You!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Your reservation has been confirmed successfully.</p>
                <p>Please check your email for confirmation details.</p>
            </div>
        </div>
    </div>
</div>



<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === Step 1 ke Step 2 ===
        const nextBtnToStep2 = document.getElementById("nextToStep2");
        nextBtnToStep2.addEventListener("click", function(e) {
            e.preventDefault();

            const checkbox = document.getElementById("agreeCheckStep1");
            if (!checkbox.checked) {
                alert("Please agree to the terms and conditions before proceeding.");
                return;
            }

            const modal1 = bootstrap.Modal.getInstance(document.getElementById("reservationModal"));
            const modal2El = document.getElementById("Step2");
            const modal2 = new bootstrap.Modal(modal2El);

            modal1.hide();
            setTimeout(() => modal2.show(), 300);
        });

        // === Step 2 ke Step 3 ===
        const nextBtnToStep3 = document.getElementById("nextToStep3");
        nextBtnToStep3.addEventListener("click", function(e) {
            e.preventDefault();

            const diet1 = document.getElementById("dietCheck1");
            const diet2 = document.getElementById("dietCheck2");
            const terms = document.getElementById("termsCheck");

            if (!diet1.checked || !diet2.checked) {
                alert("Please agree to all dietary policies before proceeding.");
                return;
            }

            if (!terms.checked) {
                alert("Please agree to the terms and conditions before proceeding.");
                return;
            }

            const modal2 = bootstrap.Modal.getInstance(document.getElementById("Step2"));
            const modal3El = document.getElementById("Step3");
            const modal3 = new bootstrap.Modal(modal3El);

            modal2.hide();
            setTimeout(() => modal3.show(), 300);
        });

        // === Step 2 kembali ke Step 1 ===
        const backBtnToStep1 = document.getElementById("backToStep1");
        backBtnToStep1.addEventListener("click", function() {
            const modal2 = bootstrap.Modal.getInstance(document.getElementById("Step2"));
            const modal1El = document.getElementById("reservationModal");
            const modal1 = new bootstrap.Modal(modal1El);

            modal2.hide();
            setTimeout(() => modal1.show(), 300);
        });

        // === Step 3 kembali ke Step 2 ===
        const backBtnToStep2 = document.getElementById("backToStep2");
        backBtnToStep2.addEventListener("click", function() {
            const modal3 = bootstrap.Modal.getInstance(document.getElementById("Step3"));
            const modal2El = document.getElementById("Step2");
            const modal2 = new bootstrap.Modal(modal2El);

            modal3.hide();
            setTimeout(() => modal2.show(), 300);
        });

        // === Step 3 Submit ===
        const finalNextBtn = document.getElementById("reservation");
        finalNextBtn.addEventListener("click", function() {
            const lastCheck = document.getElementById("lastCheck");
            if (!lastCheck.checked) {
                alert("Please agree to the cancellation policy before proceeding.");
                return;
            }

            const modal3 = bootstrap.Modal.getInstance(document.getElementById("Step3"));
            modal3.hide();

            const modal4El = document.getElementById("Step4");
            const modal4 = new bootstrap.Modal(modal4El);

            setTimeout(() => {
                modal4.show();
            }, 300);
        });

    });
</script>
