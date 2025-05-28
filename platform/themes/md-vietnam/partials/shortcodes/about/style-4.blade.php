<section class="about-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="about-content">
                    <div class="sec-title">
                        <span class="sub-title">{{ $shortcode->subtitle }}</span>
                        <h2 class="h2-title">{{ $shortcode->title }}</h2>
                    </div>
                    @if ($shortcode->description_editor)
                    <div class="about-text">
                        <p>
                            {!! $shortcode->description_editor !!}
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
            <div class="col-lg-6">
                <div class="about-image-content">
                    <img src="{{ RvMedia::getImageUrl($shortcode->image_2) }}" alt="{{ $shortcode->title }}">
                </div>
            </div>
        </div>
    </div>
</section>
