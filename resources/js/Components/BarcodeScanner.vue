<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Quagga from 'quagga';

const props = defineProps({
    onDetected: {
        type: Function,
        required: true
    }
});

const scannerRef = ref(null);
let quaggaInstance = null;

const startScanner = () => {
    if (!scannerRef.value) return;

    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: scannerRef.value,
            constraints: {
                facingMode: "environment"
            },
        },
        decoder: {
            readers: ["ean_reader", "ean_8_reader", "code_128_reader", "code_39_reader", "upc_reader"]
        }
    }, (err) => {
        if (err) {
            console.error(err);
            return;
        }
        quaggaInstance = Quagga;
        Quagga.start();
    });

    Quagga.onDetected((result) => {
        if (result.codeResult) {
            props.onDetected(result.codeResult.code);
        }
    });
};

onMounted(() => {
    startScanner();
});

onUnmounted(() => {
    if (quaggaInstance) {
        quaggaInstance.stop();
    }
});
</script>

<template>
    <div class="w-full max-w-[640px] mx-auto">
        <div ref="scannerRef" class="w-full h-[300px] relative border-[3px] border-[#00ff00] overflow-hidden">
            <video class="w-full h-full object-cover"></video>
            <canvas class="absolute top-0 left-0"></canvas>
        </div>
    </div>
</template>