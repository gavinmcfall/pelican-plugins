@props(['html' => ''])

@once
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
@endonce

<div
    x-data="{
        init() {
            this.loadHighlightJs();

            // Re-highlight after any Livewire update
            Livewire.hook('commit', ({ succeed }) => {
                succeed(() => {
                    this.$nextTick(() => this.highlight());
                });
            });
        },
        loadHighlightJs() {
            if (typeof window.hljs === 'undefined') {
                if (!document.getElementById('hljs-script')) {
                    const script = document.createElement('script');
                    script.id = 'hljs-script';
                    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js';
                    script.onload = () => this.highlight();
                    document.head.appendChild(script);
                } else {
                    const check = setInterval(() => {
                        if (typeof window.hljs !== 'undefined') {
                            clearInterval(check);
                            this.highlight();
                        }
                    }, 50);
                }
            } else {
                this.highlight();
            }
        },
        highlight() {
            if (typeof window.hljs === 'undefined') return;
            this.$el.querySelectorAll('pre code').forEach((block) => {
                block.removeAttribute('data-highlighted');
                window.hljs.highlightElement(block);
            });
        }
    }"
    class="prose prose-sm dark:prose-invert max-w-none p-4 bg-gray-50 dark:bg-gray-800 rounded-lg overflow-auto document-content"
>
    {!! $html !!}
</div>

<style>
    /* Inline preview styles for admin panel (CSS file only loads in server panel) */
    .document-content h1 { font-size: 1.875rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; }
    .document-content h2 { font-size: 1.5rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem; }
    .document-content h3 { font-size: 1.25rem; font-weight: 600; margin-top: 1.25rem; margin-bottom: 0.5rem; }
    .document-content h4 { font-size: 1.125rem; font-weight: 600; margin-top: 1rem; margin-bottom: 0.5rem; }
    .document-content p { margin-top: 0.75rem; margin-bottom: 0.75rem; line-height: 1.625; }
    .document-content ul, .document-content ol { margin-top: 0.75rem; margin-bottom: 0.75rem; padding-left: 1.5rem; }
    .document-content ul { list-style-type: disc; }
    .document-content ol { list-style-type: decimal; }
    .document-content li { margin-top: 0.25rem; margin-bottom: 0.25rem; }
    .document-content li > p { margin: 0; display: inline; }
    .document-content strong { font-weight: 600; }
    .document-content em { font-style: italic; }
    .document-content code {
        background-color: #1f2937;
        padding: 0.125rem 0.375rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: ui-monospace, SFMono-Regular, 'SF Mono', Menlo, Consolas, 'Liberation Mono', monospace;
        color: #60a5fa;
    }
    .document-content pre {
        background-color: #111827;
        padding: 1rem;
        border-radius: 0.5rem;
        overflow-x: auto;
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #374151;
    }
    .document-content pre code {
        background: none;
        padding: 0;
        color: #e5e7eb;
        font-size: 0.875rem;
        line-height: 1.5;
    }
    .document-content a { color: #60a5fa; text-decoration: underline; }
    .document-content blockquote {
        border-left: 4px solid #4b5563;
        padding-left: 1rem;
        margin: 1rem 0;
        color: #9ca3af;
        font-style: italic;
    }
    .document-content hr { border-color: #374151; margin: 1.5rem 0; }
    .document-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
    .document-content th, .document-content td { border: 1px solid #374151; padding: 0.5rem 0.75rem; text-align: left; }
    .document-content th { background-color: #1f2937; font-weight: 600; }
</style>
