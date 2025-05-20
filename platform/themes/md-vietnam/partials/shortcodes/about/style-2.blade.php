<section class="about-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-image-content">
                    <div class="about-image-box-wp">
                        <div class="about-image-box-bg">
                            <div class="about-image-bg-shape"></div>
                        </div>
                        <div class="about-image">
                            <img src="https://html.geekcodelab.com/courseshub/assets/images/about-us-image.png"
                                width="444" height="557" alt="About Us Image">
                        </div>
                        <div class="about-image-icon-wp">
                            <div class="about-image-icon top-icon">
                                <img src="https://html.geekcodelab.com/courseshub/assets/images/ribbon-tag-1-icon.png"
                                    width="56" height="56" alt="About Image Icon">
                            </div>
                            <div class="about-image-icon bottom-icon">
                                <img src="https://html.geekcodelab.com/courseshub/assets/images/academic-cap-1.png"
                                    width="56" height="56" alt="About Image Icon">
                            </div>
                        </div>
                    </div>
                    <div class="students-endroll-box move-element-animation-2">
                        <div class="students-endroll-title">
                            <h5 class="h5-title">About us</h5>
                        </div>
                        <div class="students-endroll-image">
                            <img src="https://html.geekcodelab.com/courseshub/assets/images/graph-image.svg" width="217"
                                height="80" alt="Graph Image">
                        </div>
                        <div class="students-endroll-text">
                            <p>100% Than Last Month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="about-content">
                    <div class="sec-title">
                        <span class="sub-title">{{ $shortcode->subtitle }}</span>
                        <h2 class="h2-title">{{ $shortcode->title }}</h2>
                    </div>
                    @if ($shortcode->description)
                    <div class="about-text">
                        <p>
                            {{ $shortcode->description }}
                        </p>
                    </div>
                    @endif
                    <div class="about-feature-info">
                        @foreach ($tabFeatureBoxs as $tabFeatureBox)
                        <div class="about-feature-box">
                            <div class="about-feature-icon">

                                {{ RvMedia::image($tabFeatureBox['ft_image'],
                                $tabFeatureBox['ft_title'], null, true, ['width' => 25, 'height' => 25] ) }}

                            </div>
                            <div class="about-feature-text">
                                <h4 class="h4-title">{{ $tabFeatureBox['ft_title'] }}</h4>
                                <p>{{ $tabFeatureBox['ft_description'] }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    @if($shortcode->action_label)
                    <div class="about-content-btn">
                        <a href="{{ $shortcode->action_url }}" class="sec-btn">
                            <span>{{ $shortcode->action_label }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
