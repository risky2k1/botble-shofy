<section class="about-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="about-counter-row" id="about_counter">
                    @foreach ($tabCounterBoxs as $tabCounterBox)
                    <div class="about-counter-box-wp">
                        <div class="about-counter-box">
                            <h3 class="h3-title">
                                <span class="counting" data-count="{{ $tabCounterBox['count_number'] ?? 0 }}">{{
                                    $tabCounterBox['count_number'] ?? 0 }}</span>+
                            </h3>
                            <div class="about-counter-text">
                                <p>{{ $tabCounterBox['description'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
