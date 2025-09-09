@push('styles')
<style>
/* Process section styling */
.process-section {
    position: relative;
}

.process-steps {
    margin-top: 20px;
}

.value-inner-content {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.value-inner-content:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.value-inner-content .number {
    flex-shrink: 0;
    margin-top: 5px;
}

.value-inner-content .number span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    font-weight: bold;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(0,123,255,0.3);
}

.value-inner-content .number span.bg-2 {
    background: #28a745;
    box-shadow: 0 2px 8px rgba(40,167,69,0.3);
}

.value-inner-content .number span.bg-3 {
    background: #ffc107;
    color: #333;
    box-shadow: 0 2px 8px rgba(255,193,7,0.3);
}

/* Rich content styling for process steps */
.step-content.rich-content {
    flex: 1;
    margin-top: 0;
}

/* Remove default margins and handle CKEditor output */
.step-content.rich-content > *:first-child {
    margin-top: 0 !important;
}

.step-content.rich-content > *:last-child {
    margin-bottom: 0 !important;
}

.step-content.rich-content h1,
.step-content.rich-content h2,
.step-content.rich-content h3,
.step-content.rich-content h4,
.step-content.rich-content h5,
.step-content.rich-content h6 {
    margin-bottom: 15px;
    margin-top: 0;
    font-weight: 600;
    color: #333;
    line-height: 1.3;
}

.step-content.rich-content h1 {
    font-size: 1.5rem;
}

.step-content.rich-content h2 {
    font-size: 1.3rem;
}

.step-content.rich-content h3 {
    font-size: 1.2rem;
}

.step-content.rich-content h4 {
    font-size: 1.1rem;
    color: #007bff;
    margin-bottom: 10px;
}

.step-content.rich-content p {
    margin-bottom: 12px;
    line-height: 1.6;
    color: #666;
}

/* Handle empty paragraphs and nbsp */
.step-content.rich-content p:empty,
.step-content.rich-content p:has(> br:only-child),
.step-content.rich-content p:has(> &nbsp;:only-child) {
    display: none;
}

/* Remove extra spacing from paragraphs with only whitespace */
.step-content.rich-content p:has(> br:only-child) {
    margin: 0;
    padding: 0;
    height: 0;
    overflow: hidden;
}

.step-content.rich-content ul,
.step-content.rich-content ol {
    margin-bottom: 15px;
    padding-left: 20px;
}

.step-content.rich-content li {
    margin-bottom: 5px;
    line-height: 1.6;
    color: #666;
}

.step-content.rich-content a {
    color: #007bff;
    text-decoration: none;
}

.step-content.rich-content a:hover {
    color: #0056b3;
    text-decoration: underline;
}

.step-content.rich-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 15px;
    margin: 15px 0;
    font-style: italic;
    color: #555;
    background-color: #f8f9fa;
    padding: 10px 15px;
    border-radius: 0 4px 4px 0;
}

.step-content.rich-content strong {
    font-weight: 600;
    color: #333;
}

.step-content.rich-content em {
    font-style: italic;
}

.step-content.rich-content u {
    text-decoration: underline;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .value-inner-content {
        flex-direction: column;
        gap: 15px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .value-inner-content .number {
        align-self: flex-start;
    }
    
    .value-inner-content .number span {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
    
    .step-content.rich-content h1 {
        font-size: 1.3rem;
    }
    
    .step-content.rich-content h2 {
        font-size: 1.2rem;
    }
    
    .step-content.rich-content h3 {
        font-size: 1.1rem;
    }
    
    .step-content.rich-content h4 {
        font-size: 1rem;
    }
    
    .process-steps {
        margin-top: 15px;
    }
}

@media (max-width: 576px) {
    .value-inner-content {
        padding: 12px;
        margin-bottom: 15px;
    }
    
    .value-inner-content .number span {
        width: 35px;
        height: 35px;
        font-size: 12px;
    }
    
    .step-content.rich-content {
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clean up CKEditor output in process steps
    const stepContents = document.querySelectorAll('.step-content.rich-content');
    
    stepContents.forEach(function(content) {
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

@if($processes && $processes->count() > 0)
    @foreach($processes as $processIndex => $process)
        <section class="value-area ptb-100 process-section {{ $processIndex > 0 ? 'mt-0' : '' }}">
            <div class="container">
                <div class="row align-items-center">
                    @if($process->image)
                        <div class="col-lg-6">
                            <div class="value-image">
                                <img src="{{ $process->image_url }}" alt="{{ $process->title }}" class="img-fluid rounded shadow-sm">
                            </div>
                        </div>
                    @endif

                    <div class="col-lg-{{ $process->image ? '6' : '12' }}">
                        <div class="value-item">
                            <div class="value-content">
                                <h3 class="mb-4">{{ $process->title }}</h3>
                            </div>

                            @if($process->steps && $process->steps->count() > 0)
                                <div class="process-steps">
                                    @foreach($process->steps as $index => $step)
                                        <div class="value-inner-content mb-4">
                                            @if($step->content)
                                                {{-- Show number for each step --}}
                                                <div class="number">
                                                    <span class="{{ $index % 3 == 0 ? '' : ($index % 3 == 1 ? 'bg-2' : 'bg-3') }}">
                                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                    </span>
                                                </div>
                                                {{-- Display rich content with proper styling --}}
                                                <div class="step-content rich-content">
                                                    {!! $step->content !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(!$process->image)
                        {{-- If no image, show a default image or leave empty --}}
                        @if($process->steps && $process->steps->count() > 0)
                            <div class="col-lg-6">
                                <div class="value-image">
                                    <img src="{{ asset('front/assets/img/value/value-1.png') }}" alt="{{ $process->title }}" class="img-fluid rounded shadow-sm">
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </section>
    @endforeach
@else
    {{-- Fallback to static content if no processes are found --}}
    <section class="value-area ptb-100 process-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="value-image">
                        <img src="{{ asset('front/assets/img/value/value-1.png') }}" alt="image">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="value-item">
                        <div class="value-content">
                            <h3>We are Refunding Early Childcare Education</h3>
                        </div>

                        <div class="value-inner-content">
                            <div class="number">
                                <span>01</span>
                            </div>
                            <h4>Active Learning</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>

                        <div class="value-inner-content">
                            <div class="number">
                                <span class="bg-2">02</span>
                            </div>
                            <h4>Safe Environment</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>

                        <div class="value-inner-content">
                            <div class="number">
                                <span class="bg-3">03</span>
                            </div>
                            <h4>Fully Equipment</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
