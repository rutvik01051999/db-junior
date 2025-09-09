@props(['bannerSections'])

@push('styles')
<style>
/* Banner rich content styling */
.banner-description.rich-content {
    line-height: 1.6;
}

.banner-description.rich-content h1,
.banner-description.rich-content h2,
.banner-description.rich-content h3,
.banner-description.rich-content h4,
.banner-description.rich-content h5,
.banner-description.rich-content h6 {
    margin-bottom: 15px;
    margin-top: 0;
    font-weight: 600;
    color: #333;
    line-height: 1.3;
}

.banner-description.rich-content h1 {
    font-size: 1.8rem;
}

.banner-description.rich-content h2 {
    font-size: 1.6rem;
}

.banner-description.rich-content h3 {
    font-size: 1.4rem;
}

.banner-description.rich-content h4 {
    font-size: 1.2rem;
    color: #007bff;
}

.banner-description.rich-content p {
    margin-bottom: 12px;
    line-height: 1.6;
    color: #333;
}

.banner-description.rich-content ul,
.banner-description.rich-content ol {
    margin-bottom: 15px;
    padding-left: 20px;
}

.banner-description.rich-content li {
    margin-bottom: 5px;
    line-height: 1.5;
}

.banner-description.rich-content a {
    color: #007bff;
    text-decoration: none;
}

.banner-description.rich-content a:hover {
    text-decoration: underline;
}

.banner-description.rich-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 15px;
    margin: 15px 0;
    font-style: italic;
    color: #666;
}

.banner-description.rich-content strong,
.banner-description.rich-content b {
    font-weight: 600;
    color: #333;
}

.banner-description.rich-content em,
.banner-description.rich-content i {
    font-style: italic;
}

.banner-description.rich-content u {
    text-decoration: underline;
}

/* Handle empty paragraphs and nbsp */
.banner-description.rich-content p:empty,
.banner-description.rich-content p:has(> br:only-child) {
    display: none;
}

/* Remove default margins */
.banner-description.rich-content > *:first-child {
    margin-top: 0 !important;
}

.banner-description.rich-content > *:last-child {
    margin-bottom: 0 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .banner-description.rich-content {
        font-size: 16px !important;
    }
    
    .banner-description.rich-content h1 {
        font-size: 1.5rem;
    }
    
    .banner-description.rich-content h2 {
        font-size: 1.3rem;
    }
    
    .banner-description.rich-content h3 {
        font-size: 1.2rem;
    }
    
    .banner-description.rich-content h4 {
        font-size: 1.1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clean up CKEditor output in banner descriptions
    const bannerDescriptions = document.querySelectorAll('.banner-description.rich-content');
    
    bannerDescriptions.forEach(function(content) {
        // Remove empty paragraphs
        const emptyParagraphs = content.querySelectorAll('p');
        emptyParagraphs.forEach(function(p) {
            const text = p.textContent.trim();
            if (text === '' || text === '\u00A0' || text === '&nbsp;') {
                p.remove();
            }
        });
        
        // Remove paragraphs that only contain <br> tags
        const brOnlyParagraphs = content.querySelectorAll('p');
        brOnlyParagraphs.forEach(function(p) {
            if (p.innerHTML.trim() === '<br>' || p.innerHTML.trim() === '<br/>') {
                p.remove();
            }
        });
        
        // Clean up any remaining &nbsp; entities
        content.innerHTML = content.innerHTML.replace(/&nbsp;/g, '');
        
        // Remove any remaining empty paragraphs
        const remainingParagraphs = content.querySelectorAll('p');
        remainingParagraphs.forEach(function(p) {
            if (p.textContent.trim() === '') {
                p.remove();
            }
        });
    });
});
</script>
@endpush

@if($bannerSections && $bannerSections->count() > 0)
    @foreach($bannerSections as $banner)
        <div class="main-banner-item banner-item-two">
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="main-banner-image-wrap">
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">

                                    <div class="banner-image-wrap-shape">
                                        <img src="{{ asset('front/assets/img/main-banner/main-banner-shape-1.png') }}" alt="image">
                                    </div>
                                </div>
                                @if($banner->title || $banner->description)
                                    <br>
                                    <div class="banner-content">
                                        @if($banner->title)
                                            <h3 style="text-align:center;color: #2882C3;" class="mb-3">{{ $banner->title }}</h3>
                                        @endif
                                        @if($banner->description)
                                            <div class="banner-description rich-content" style="color: black;max-width: 103%;font-size: 18px;text-align: center;">
                                                {!! $banner->description !!}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    {{-- Fallback banner content --}}
    <div class="main-banner-item banner-item-two">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="main-banner-image-wrap">
                                <img src="{{ asset('front/assets/img/1.jpeg') }}" alt="image">

                                <div class="banner-image-wrap-shape">
                                    <img src="{{ asset('front/assets/img/main-banner/main-banner-shape-1.png') }}" alt="image">
                                </div>
                            </div>
                            <br>
                            <p style="max-width: 100%;"><b>The Hon'ble Vice President of India, Shri Jagdeep Dhankhar, along with the national winners of Junior Editor - 7, at the Felicitation Ceremony held at <br>Sansad Bhavan, New Delhi, on July 18th, 2024.</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
