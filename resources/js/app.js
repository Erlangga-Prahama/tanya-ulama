import Quill from "quill";
import "quill/dist/quill.snow.css";
import * as pdfjsLib from "pdfjs-dist";
import pdfjsWorker from "pdfjs-dist/build/pdf.worker?url";

// Inisialisasi Quill setelah Livewire siap
document.addEventListener("livewire:navigated", () => initQuill());
document.addEventListener("DOMContentLoaded", () => initQuill());

function initQuill() {
    const editorEl = document.getElementById("quill-editor");
    const inputEl = document.getElementById("quill-content");

    if (!editorEl || editorEl.__quill) return; // Hindari init ulang

    const quill = new Quill(editorEl, {
        theme: "snow",
        modules: {
            toolbar: [
                ["bold", "italic", "underline", "strike"],
                [{ list: "ordered" }, { list: "bullet" }],
                [{ direction: "rtl" }],
            ],
        },
    });

    editorEl.__quill = quill;

    // Sync Quill → Livewire
    quill.on("text-change", () => {
        inputEl.value = quill.root.innerHTML;
        inputEl.dispatchEvent(new Event("input"));
    });
}

pdfjsLib.GlobalWorkerOptions.workerSrc = pdfjsWorker;

async function initPDF() {
    const container = document.getElementById("pdf-container");
    if (!container || !window.__PDF_BASE64__ || container.__pdfLoaded) return;

    container.__pdfLoaded = true; // Guard agar tidak double

    const pdfData = atob(window.__PDF_BASE64__);
    const pdfArray = new Uint8Array(pdfData.length);
    for (let i = 0; i < pdfData.length; i++) {
        pdfArray[i] = pdfData.charCodeAt(i);
    }

    const pdfDoc = await pdfjsLib.getDocument({ data: pdfArray }).promise;

    for (let num = 1; num <= pdfDoc.numPages; num++) {
        const page = await pdfDoc.getPage(num);
        const viewport = page.getViewport({ scale: 1.5 });

        const canvas = document.createElement("canvas");
        canvas.width = viewport.width;
        canvas.height = viewport.height;
        canvas.className = "w-full rounded shadow-sm";
        container.appendChild(canvas);

        await page.render({ canvasContext: canvas.getContext("2d"), viewport })
            .promise;
    }
}

document.addEventListener("DOMContentLoaded", initPDF);
document.addEventListener("livewire:navigated", initPDF);
