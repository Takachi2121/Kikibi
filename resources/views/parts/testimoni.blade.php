<section class="testimoni-section mb-5">
    <div class="container text-center">
        <h1>Testimoni</h1>
        <p class="fs-5">Cerita dari mereka yang berhasil bikin momen lebih berkesan.</p>
        <div class="row g-4">
            <!-- Card -->
            @foreach($testimoni as $data)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-start">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                @if ($data->foto)
                                    <img src="{{ asset('assets/img/Testimoni/' . $data->foto) }}"
                                    alt="User"
                                    width="40"
                                    height="40"
                                    class="rounded-circle object-fit-cover" style="object-position: top;">
                                @else
                                    <img src="{{ asset('assets/img/Testimoni/default.png') }}"
                                    alt="User"
                                    width="40"
                                    height="40"
                                    class="rounded-circle">
                                @endif
                                <h6 class="mb-0 fw-semibold">{{ $data->nama }}</h6>
                            </div>

                            <div class="text-warning align-self-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $data->rating)
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @else
                                        <i class="fa-regular fa-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        <p class="text-muted small">
                            {{ $data->komentar }}
                        </p>

                        {{-- <div class="d-flex align-items-center gap-2 text-muted small">
                            <i class="fa-regular fa-heart"></i>
                            <span>200 Like</span>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
