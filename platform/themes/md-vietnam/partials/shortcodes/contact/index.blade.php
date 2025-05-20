<section class="contact-section py-16">
    <div class="container mx-auto px-4">
        @if ($shortcode->title || $shortcode->subtitle)
            <div class="text-center mb-12">
                @if ($shortcode->subtitle)
                    <p class="text-primary text-lg mb-2">{{ $shortcode->subtitle }}</p>
                @endif
                @if ($shortcode->title)
                    <h2 class="text-4xl font-bold mb-4">{{ $shortcode->title }}</h2>
                @endif
                @if ($shortcode->description)
                    <p class="text-gray-600">{{ $shortcode->description }}</p>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="contact-info bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-2xl font-semibold mb-6">{{ __('Contact Information') }}</h3>

                @if ($shortcode->address)
                    <div class="flex items-start mb-6">
                        <span class="text-primary mr-3">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </span>
                        <div>
                            <h4 class="font-medium mb-1">{{ __('Address') }}</h4>
                            <p class="text-gray-600">{{ $shortcode->address }}</p>
                        </div>
                    </div>
                @endif

                @if ($shortcode->phone)
                    <div class="flex items-start mb-6">
                        <span class="text-primary mr-3">
                            <i class="fas fa-phone-alt text-xl"></i>
                        </span>
                        <div>
                            <h4 class="font-medium mb-1">{{ __('Phone') }}</h4>
                            <p class="text-gray-600">{{ $shortcode->phone }}</p>
                        </div>
                    </div>
                @endif

                @if ($shortcode->email)
                    <div class="flex items-start">
                        <span class="text-primary mr-3">
                            <i class="fas fa-envelope text-xl"></i>
                        </span>
                        <div>
                            <h4 class="font-medium mb-1">{{ __('Email') }}</h4>
                            <p class="text-gray-600">{{ $shortcode->email }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="contact-form bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-2xl font-semibold mb-6">{{ __('Send us a message') }}</h3>
                {!! Form::open(['route' => 'public.send.contact', 'method' => 'POST', 'class' => 'contact-form']) !!}
                    <div class="mb-6">
                        <input type="text"
                               name="name"
                               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary"
                               placeholder="{{ __('Your Name') }}"
                               required>
                    </div>
                    <div class="mb-6">
                        <input type="email"
                               name="email"
                               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary"
                               placeholder="{{ __('Your Email') }}"
                               required>
                    </div>
                    <div class="mb-6">
                        <textarea name="content"
                                  rows="5"
                                  class="w-full px-4 py-2 border rounded focus:outline-none focus:border-primary"
                                  placeholder="{{ __('Your Message') }}"
                                  required></textarea>
                    </div>
                    <button type="submit"
                            class="bg-primary text-white px-8 py-3 rounded hover:bg-primary-dark transition duration-300">
                        {{ __('Send Message') }}
                    </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
