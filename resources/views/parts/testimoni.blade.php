<section class="testimoni-section">
    <div class="container text-center">
        <h1>Testimoni</h1>
        <p class="fs-5">Cerita dari mereka yang berhasil bikin momen lebih berkesan.</p>
        <div class="row g-4">
            <!-- Card -->
            @for ($i = 0; $i < 6; $i++)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-start">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/img/Background/Person.png') }}"
                                alt="User"
                                width="40"
                                height="40"
                                class="rounded-circle">
                                <h6 class="mb-0 fw-semibold">John Doe</h6>
                            </div>

                            <div class="text-warning align-self-center">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star text-muted"></i>
                            </div>
                        </div>

                        <p class="text-muted small mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>

                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="fa-regular fa-heart"></i>
                            <span>200 Like</span>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>
