@props(['mainContent'])

@push('styles')
<style>
/* Main content rich content styling */
.main-content-description.rich-content {
    line-height: 1.6;
    margin-bottom: 20px;
}

.main-content-description.rich-content h1,
.main-content-description.rich-content h2,
.main-content-description.rich-content h3,
.main-content-description.rich-content h4,
.main-content-description.rich-content h5,
.main-content-description.rich-content h6 {
    margin-bottom: 15px;
    margin-top: 0;
    font-weight: 600;
    color: #333;
    line-height: 1.3;
}

.main-content-description.rich-content h1 {
    font-size: 1.8rem;
}

.main-content-description.rich-content h2 {
    font-size: 1.6rem;
}

.main-content-description.rich-content h3 {
    font-size: 1.4rem;
}

.main-content-description.rich-content h4 {
    font-size: 1.2rem;
    color: #007bff;
}

.main-content-description.rich-content p {
    margin-bottom: 12px;
    line-height: 1.6;
    color: #666;
}

.main-content-description.rich-content ul,
.main-content-description.rich-content ol {
    margin-bottom: 15px;
    padding-left: 20px;
}

.main-content-description.rich-content li {
    margin-bottom: 5px;
    line-height: 1.5;
}

.main-content-description.rich-content a {
    color: #007bff;
    text-decoration: none;
}

.main-content-description.rich-content a:hover {
    text-decoration: underline;
}

.main-content-description.rich-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 15px;
    margin: 15px 0;
    font-style: italic;
    color: #666;
}

.main-content-description.rich-content strong,
.main-content-description.rich-content b {
    font-weight: 600;
    color: #333;
}

.main-content-description.rich-content em,
.main-content-description.rich-content i {
    font-style: italic;
}

.main-content-description.rich-content u {
    text-decoration: underline;
}

/* Handle empty paragraphs and nbsp */
.main-content-description.rich-content p:empty,
.main-content-description.rich-content p:has(> br:only-child) {
    display: none;
}

/* Remove default margins */
.main-content-description.rich-content > *:first-child {
    margin-top: 0 !important;
}

.main-content-description.rich-content > *:last-child {
    margin-bottom: 0 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-content-description.rich-content {
        font-size: 14px;
    }
    
    .main-content-description.rich-content h1 {
        font-size: 1.5rem;
    }
    
    .main-content-description.rich-content h2 {
        font-size: 1.3rem;
    }
    
    .main-content-description.rich-content h3 {
        font-size: 1.2rem;
    }
    
    .main-content-description.rich-content h4 {
        font-size: 1.1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clean up CKEditor output in main content descriptions
    const mainContentDescriptions = document.querySelectorAll('.main-content-description.rich-content');
    
    mainContentDescriptions.forEach(function(content) {
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

<section class="who-we-are ptb-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="who-we-are-content" id="about">
                    @if($mainContent)
                        @if($mainContent->title)
                            <h3>{{ $mainContent->title }}</h3>
                        @endif
                        @if($mainContent->description)
                            <div class="main-content-description rich-content">
                                {!! $mainContent->description !!}
                            </div>
                        @endif
                        <br>
                        <h4>Participation Categories</h4>
                        <ul class="who-we-are-list">
                            @if($mainContent->participation_categories_1)
                                <li style="display: flex;">
                                    <span>1</span>
                                    <h6>{{ $mainContent->participation_categories_1 }}</h6>
                                </li>
                            @endif
                            @if($mainContent->participation_categories_2)
                                <li style="display: flex;">
                                    <span>2</span>
                                    <h6>{{ $mainContent->participation_categories_2 }}</h6>
                                </li>
                            @endif
                            @if($mainContent->participation_categories_3)
                                <li style="display: flex;">
                                    <span>3</span>
                                    <h6>{{ $mainContent->participation_categories_3 }}</h6>
                                </li>
                            @endif
                            @if($mainContent->participation_categories_4)
                                <li style="display: flex;">
                                    <span>4</span>
                                    <h6>{{ $mainContent->participation_categories_4 }}</h6>
                                </li>
                            @endif
                        </ul>
                        <br>
                        <h4>Timeline</h4>
                        <ul class="who-we-are-list">
                            @if($mainContent->timeline_1)
                                <li>
                                    <span>1</span>
                                    {{ $mainContent->timeline_1 }}
                                </li>
                            @endif
                            @if($mainContent->timeline_2)
                                <li>
                                    <span>2</span>
                                    {{ $mainContent->timeline_2 }}
                                </li>
                            @endif
                            @if($mainContent->timeline_3)
                                <li>
                                    <span>3</span>
                                    {{ $mainContent->timeline_3 }}
                                </li>
                            @endif
                            @if($mainContent->timeline_4)
                                <li>
                                    <span>4</span>
                                    {{ $mainContent->timeline_4 }}
                                </li>
                            @endif
                        </ul>
                    @else
                        {{-- Fallback content --}}
                        <h3>Junior Editor</h3>
                        <p>Junior Editor (JE) is India's Largest Newspaper Making Competition which is a pre-designed four-page broadsheet layout. Junior Editor is a unique activity for children that blends the elements of editing, designing, reporting, and creative writing. JE gives you a chance to create your own newspaper by making headlines, crafting stories, and writing editorials. Specific guidelines in the broadsheet will help you through the writing and illustration process. Junior Editor has clinched the highest honours from multiple distinguished organizations. It has been acknowledged by the 'Guinness World Records' (The Largest Writing Competition), the 'Limca World Record' (The Largest Countrywide Newspaper Making Competition for Children), and the India Book of Records for producing the most hand-made newspapers by children. Junior Editor is available in three editions : Dainik Bhaskar, Divya Bhaskar and Divya Marathi. You have the opportunity to create your own newspaper in either Hindi, English, Gujarati, or Marathi.</p>
                        <br>
                        <h4>Participation Categories</h4>
                        <ul class="who-we-are-list">
                            <li style="display: flex;">
                                <span>1</span>
                                <h6>Category A</h6>- Class 4th, 5th and 6th
                            </li>
                            <li style="display: flex;">
                                <span>2</span>
                                <h6>Category B</h6> - Class 7th, 8th and 9th
                            </li>
                            <li style="display: flex;">
                                <span>3</span>
                                <h6>Category C</h6>- Class 10th, 11th and 12th
                            </li>
                        </ul>
                        <br>
                        <h4>Timeline</h4>
                        <ul class="who-we-are-list">
                            <li>
                                <span>1</span>
                                Registration Starts: 4th December, 2023
                            </li>
                            <li>
                                <span>2</span>
                                Registration Ends: 15th January, 2024
                            </li>
                            <li>
                                <span>3</span>
                                Competition Date: 20th January, 2024
                            </li>
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="who-we-are-image-wrap shadow-custom">
                    @if($mainContent && $mainContent->image)
                        <img src="{{ asset('storage/' . $mainContent->image) }}" alt="{{ $mainContent->title ?? 'Image' }}">
                    @else
                        <img src="{{ asset('front/assets/img/quote.jpg') }}" alt="image">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
