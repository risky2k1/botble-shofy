<section class="about-product1">
    <div class="container">
        <div class="hedding-about1">
            @if ($shortcode->subtitle)
                <span>{{ $shortcode->subtitle }}</span>
            @endif
            @if ($shortcode->title)
                <h2>{{ $shortcode->title }}</h2>
            @endif
            @if ($shortcode->subtitle_2)
                <a href="javascript:void(0)">{{ $shortcode->subtitle_2 }}</a>
            @endif
        </div>
        <div class="box-body-about-product1">
            <div class="box-section-member-about-row">
                {{-- @dd($shortcode->description_editor) --}}
                <div class="ck-content">
                    {{-- {!! BaseHelper::clean($shortcode->description_editor) !!} --}}
                    {!! $shortcode->description_editor !!}
                </div>
            </div>
            {{-- <div class="col-lg-6">
                        <div class="content-about-product-1">
                            @if ($shortcode->description_editor)
                                <p>
                                    {!! $shortcode->description_editor !!}
                                </p>
                            @endif

                            @if ($shortcode->action_label && $shortcode->action_url)
                                <div class="mt-4">
                                    <span class="btn-dangky-about1"><svg width="64px" height="64px"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M21.9438 3.33038C22.0707 2.96779 21.9787 2.56456 21.7071 2.29292C21.4354 2.02128 21.0322 1.92926 20.6696 2.05617L1.85999 8.63954C0.577721 9.08834 0.504876 10.8743 1.74631 11.426L9.24237 14.7576L12.574 22.2537C13.1257 23.4951 14.9117 23.4223 15.3605 22.14L21.9438 3.33038ZM9.77851 12.8073L3.71105 10.1106L19.37 4.63L13.8894 20.289L11.1927 14.2215L14.7071 10.7071C15.0976 10.3166 15.0976 9.68342 14.7071 9.29289C14.3166 8.90237 13.6834 8.90237 13.2929 9.29289L9.77851 12.8073Z"
                                                    fill="#000000"></path>
                                            </g>
                                        </svg>
                                        {{ $shortcode->action_label }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-about-product-1-right">
                            @if ($shortcode->youtube_iframe)
                                {!! str_replace(['“', '”'], '"', $shortcode->youtube_iframe) !!}
                            @endif
                            @if ($shortcode->description_2)
                                <p>{!! $shortcode->description_2 !!}</p>
                            @endif
                        </div>
                    </div> --}}
        </div>

        {{-- <div class="mucluc-about-products">
            <div class="box-container-mucluc-abouts">
                <h2>Mục lục</h2>
                <div class="list-mucluc-about">
                    <ul>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                        <li><a href="">I. Lý do nên chọn du học Nhật Bản năm 2025</a></li>
                    </ul>
                </div>
            </div>
        </div> --}}
    </div>
</section>
