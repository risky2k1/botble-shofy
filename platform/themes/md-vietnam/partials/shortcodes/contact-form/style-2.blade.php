<section class="contacts-section">
    <div class="container">
        <div class="box-contact-body">
            @if ($shortcode->show_contact_form)
            <div class="hedding-header-contact">
                @if ($title = $shortcode->title)
                <h1>{{ $title }}</h1>
                @endif

                @if ($description = $shortcode->description)
                <div>{{ nl2br($description, true) }}</div>
                @endif
            </div>
            @endif

            <div class="body-contact-track">
                @php
                $displayFields = explode(',', $shortcode->display_fields);
                $mandatoryFields = explode(',', $shortcode->mandatory_fields);

                // Thêm "name" vào đầu mảng nếu chưa có
                array_unshift($displayFields, 'name');
                array_unshift($mandatoryFields, 'name');

                // Loại bỏ giá trị trùng lặp để đảm bảo "name" không xuất hiện nhiều lần
                $displayFields = array_unique($displayFields);
                $mandatoryFields = array_unique($mandatoryFields);

                @endphp
                {!! Form::open(['route' => 'public.send.contact', 'method' => 'POST', 'class' => 'contact-form', 'id' => 'botble-contact-forms-fronts-contact-form']) !!}
                @foreach ($displayFields as $displayField)
                @php
                   $checkField = in_array($displayField, $mandatoryFields)
                @endphp
                <div class="item-label-form ">
                    <input type="text" name="{{ $displayField }}"
                    placeholder="{{ __('Enter Your') }} {{ __(ucfirst($displayField))}} {{ $checkField ? '*' : '' }}">
                </div>
                @endforeach
                <div class="textrax-label-form">
                    <textarea rows="3" placeholder="{{ __('Your Message') }}*" required="required" id="content"
                        name="content" cols="50" aria-required="true"></textarea>
                </div>

                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div class="policy-label-form">
                        <label class="required form-check">
                            <input type="checkbox" id="agree_terms_and_policy_243f28785407323f2c450d79cc588bc4"
                                name="agree_terms_and_policy" class="form-check-input contact-form-input"
                                required="required" value="1" aria-required="true">

                            <span class="form-check-label">
                                {{ __('I agree to the Terms and Privacy Policy') }}
                            </span>

                        </label>
                    </div>

                    {{-- <div class="baomat-contact">
                        <!-- <a href="{{ $shortcode->button_url }}">{{ $shortcode->button_label }}</a> -->
                    </div> --}}

                    <div class="btn-form-contacts">
                        <button type="submit">
                            {{ __('Send') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 12h12l-3 -3" />
                                <path d="M18 15l3 -3" />
                            </svg>
                        </button>
                    </div>

                </div>



                {!! Form::close() !!}
            </div>

        </div>
    </div>
</section>
