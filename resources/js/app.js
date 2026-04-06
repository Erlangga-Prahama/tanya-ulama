import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Inisialisasi Quill setelah Livewire siap
document.addEventListener('livewire:navigated', () => initQuill());
document.addEventListener('DOMContentLoaded', () => initQuill());

function initQuill() {
    const editorEl = document.getElementById('quill-editor');
    const inputEl  = document.getElementById('quill-content');

    if (!editorEl || editorEl.__quill) return; // Hindari init ulang

    const quill = new Quill(editorEl, {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{'direction': 'rtl'}],
            ],
        },
    });

    editorEl.__quill = quill;

    // Sync Quill → Livewire
    quill.on('text-change', () => {
        inputEl.value = quill.root.innerHTML;
        inputEl.dispatchEvent(new Event('input'));
    });
}