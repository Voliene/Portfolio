
    import { PitchDetector } from "https://esm.sh/pitchy@4";

    const noteFrequencies = {
        'C2': 65.41,
        'C#2': 69.30,
        'D2': 73.42,
        'D#2': 77.78,
        'E2': 82.41,
        'F2': 87.31,
        'F#2': 92.50,
        'G2': 98.00,
        'G#2': 103.83,
        'A2': 110.00,
        'A#2': 116.54,
        'H2': 123.47,
        'C3': 130.81,
        'C#3': 138.59,
        'D3': 146.83,
        'D#3': 155.56,
        'E3': 164.81,
        'F3': 174.61,
        'F#3': 185.00,
        'G3': 196.00,
        'G#3': 207.65,
        'A3': 220.00,
        'A#3': 233.08,
        'H3': 246.94,
        'C4': 261.63,
        'C#4': 277.18,
        'D4': 293.66,
        'D#4': 311.13,
        'E4': 329.63,
        'F4': 349.23,
        'F#4': 369.99,
        'G4': 392.00,
        'G#4': 415.30,
        'A4': 440.00,
        'A#4': 466.16,
        'H4': 493.88,
        'C5': 523.25,
        'C#5': 554.37,
        'D5': 587.33,
        'D#5': 622.25,
        'E5': 659.25,
        'F5': 698.46,
        'F#5': 739.99,
        'G5': 783.99,
        'G#5': 830.61,
        'A5': 880,
        'A#5': 932.33,
        'H5': 987.77
    };
    let drawnNoteFrequency = null;
    let randomNote = null;
    function findNoteFromFrequency(frequency, tolerance = 7.0) {
        let closestNote = null;
        let minDiff = tolerance;

        for (const note in noteFrequencies) {
            const noteFrequency = noteFrequencies[note];

            const diff = Math.abs(noteFrequency - frequency);

            if (diff <= minDiff) {
                closestNote = note;
                minDiff = diff;
            }
        }

        if (drawnNoteFrequency !== null) {
            const noteElement = document.getElementById("note");

            if (closestNote !== null) {
                const baseDrawnNote = randomNote.replace(/[0-9]/g, "");
                const baseClosestNote = closestNote.replace(/[0-9]/g, "");
                const notes = ["C", "C#", "D", "D#", "E", "F", "F#", "G", "G#", "A", "A#", "H"];
                const drawnIndex = notes.indexOf(baseDrawnNote);
                const closestIndex = notes.indexOf(baseClosestNote);
                const semitoneDiff = Math.min(
                    Math.abs(drawnIndex - closestIndex),
                    notes.length - Math.abs(drawnIndex - closestIndex)
                );

                if (semitoneDiff === 0) {
                    noteElement.style.color = "green";
                } else if (semitoneDiff === 1) {
                    noteElement.style.color = "orange";
                } else {
                    noteElement.style.color = "red";
                }
            }
        }

        return closestNote ? closestNote.replace(/[0-9]/g, "") : "___";
    }
    function drawNote(){
        const notes = Object.keys(noteFrequencies);
        const randomIndex = Math.floor(Math.random() * notes.length);
        randomNote = notes[randomIndex];
        document.getElementById("random-note").textContent = randomNote.replace(/[0-9]/g, '');
        drawnNoteFrequency = noteFrequencies[randomNote];
    }
    function updatePitch(analyserNode, detector, input, sampleRate) {
    analyserNode.getFloatTimeDomainData(input);
    const [pitch, clarity] = detector.findPitch(input, sampleRate);

    document.getElementById("pitch").textContent = `${
    Math.round(pitch * 10) / 10
} Hz`;
    document.getElementById("clarity").textContent = `${Math.round(
    clarity * 100,
    )} %`;

    const note = findNoteFromFrequency(pitch);
    if (note === "___") document.getElementById("note").style.color ="saddlebrown";
    document.getElementById("note").textContent = note;
    window.setTimeout(
    () => updatePitch(analyserNode, detector, input, sampleRate),
    100,
    );
}




    document.addEventListener("DOMContentLoaded", () => {
    const audioContext = new window.AudioContext();
    const analyserNode = audioContext.createAnalyser();

    document
    .getElementById("resume-button")
    .addEventListener("click", () => audioContext.resume());

    navigator.mediaDevices.getUserMedia({ audio: true }).then((stream) => {
    audioContext.createMediaStreamSource(stream).connect(analyserNode);
    const detector = PitchDetector.forFloat32Array(analyserNode.fftSize);
    detector.minVolumeDecibels = -30;
    const input = new Float32Array(detector.inputLength);
    updatePitch(analyserNode, detector, input, audioContext.sampleRate);
});

    document
        .getElementById("draw-button")
        .addEventListener("click", () => drawNote());

});
