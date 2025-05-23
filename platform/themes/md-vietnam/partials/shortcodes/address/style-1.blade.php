<section class="contacts-section">
    <div class="line-contact">
        <img src="{{ Theme::asset()->url(sprintf('images/contact-bg.png')) }}" alt="">
    </div>
    <div class="box-contact-article-section"
        style="background-image: url({{ RvMedia::getImageUrl($shortcode->background_image) }})">
        <div class="container">
            <div class="title-article-contact">
                <h2>{{ $shortcode->title ?? '' }}</h2>
            </div>
            <div class="list-article-item">
                <div class="row">
                    @foreach ($addressBoxes as $addressBox)

                    <div class="col-lg-6">
                        <div class="item-section-article-member">
                            <div class="number">
                                <span>{{ $loop->index + 1 }}</span>
                            </div>
                            <div class="caption-body-article">
                                <span>{{ $addressBox['company_name'] }}</span>
                                <ul>
                                    <li>{{ $addressBox['address'] }}</li>
                                    <li><i class="ti ti-phone"></i></i> {{ $addressBox['phone'] ?? '' }} </li>
                                    <li><i class="ti ti-envelope"></i>{{ $addressBox['email'] ?? '' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
