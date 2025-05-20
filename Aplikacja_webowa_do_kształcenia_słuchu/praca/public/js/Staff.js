
const { Renderer, Stave, StaveNote, Voice, Formatter } = Vex.Flow;

class Staff {
    constructor(elementId, numberOfMeasures = 6, measuresPerLine = 3) {
        const div = document.getElementById(elementId);
        const renderer = new Renderer(div, Renderer.Backends.SVG);

        this.staves = [];
        this.notes = [];
        this.totalLines = 5;
        this.numberOfMeasures = numberOfMeasures;
        this.measuresPerLine = measuresPerLine;
        const staveWidth = 420;
        const staveHeight = 150;
        const lines = Math.ceil(this.numberOfMeasures / this.measuresPerLine);
        this.currentDuration = '4';
        this.noteCursor = null;
        this.activeNote = null;
        this.initNoteCursor();
        this.currentAccidental = null; // Możliwe wartości: null, '#', 'b'
        this.isRest=null;
        renderer.resize(this.measuresPerLine * staveWidth , lines * staveHeight);
        this.context = renderer.getContext();


        const scale = 1.005;
        this.context.scale(scale, scale);


        // Tworzenie pięciolinii
        for (let line = 0; line < lines; line++) {
            for (let i = 0; i < this.measuresPerLine; i++) {
                const staveIndex = line * this.measuresPerLine + i;
                if (staveIndex >= this.numberOfMeasures) break;

                let distance=20 + line * staveHeight
                if (Math.floor(staveIndex/3) % 2 === 1) distance-=25;


                const stave = new Stave(10 + i * staveWidth, distance, staveWidth);
                if (staveIndex % 6 === 0) {
                    stave.addClef("treble").addTimeSignature("4/4");
                }cd
                if (staveIndex % 6 === 3) {
                    stave.addClef("bass").addTimeSignature("4/4");
                }
                stave.setContext(this.context).draw();
                this.staves.push(stave);
            }
        }
    }

    addLine() {
        this.numberOfMeasures += 6;
        const staveWidth = 420;
        const staveHeight = 150;

        for (let i = this.staves.length; i < this.numberOfMeasures; i++) {
            let distance = 20 + Math.floor(i / this.measuresPerLine) * staveHeight;
            if (Math.floor(i / this.measuresPerLine) % 2 === 1) distance -= 25;

            const stave = new Stave(10 + (i % this.measuresPerLine) * staveWidth, distance, staveWidth);
            if (i % 6 === 0) {
                stave.addClef("treble").addTimeSignature("4/4");
            }
            if (i % 6 === 3) {
                stave.addClef("bass").addTimeSignature("4/4");
            }
            stave.setContext(this.context).draw();
            this.staves.push(stave);

        }

        this.renderNotes();
    }

    addAccidental(note, acc) {
        return note.addModifier(f.Accidental({ type: acc }), 0);
    }
    addNoteOnClick(event) {
        const offsetY = event.offsetY;
        const offsetX = event.offsetX;

        let stave = null;

        for (const currentStave of this.staves) {
            const boundingBox = currentStave.getBoundingBox();
            const staveTop = boundingBox.y;
            const staveBottom = staveTop + boundingBox.h;

            if (offsetY >= staveTop && offsetY <= staveBottom) {
                stave = currentStave;
                break;
            }
        }

        if (!stave) {
            console.warn("Kliknięcie poza obszarem pięciolinii");
            return;
        }

        const staveHeight = stave.getBoundingBox().h;
        const staveTopY = stave.getBoundingBox().y;
        const adjustedHeight = staveHeight / (this.totalLines * 4.8);
        const offsetFromTop = offsetY - staveTopY;
        const index = Math.round(offsetFromTop / adjustedHeight);

        const noteLines = [
            'f/6', 'e/6', 'd/6', 'c/6', 'b/5', 'a/5', 'g/5',
            'f/5', 'e/5', 'd/5', 'c/5', 'b/4', 'a/4', 'g/4',
            'f/4', 'e/4', 'd/4', 'c/4', 'b/3', 'a/3', 'g/3'
        ];

        const noteName = noteLines[index] || 'c/4';

        // Obliczanie indeksu taktu
        const staveWidth = stave.width;
        const staveIndex = Math.floor(offsetX / staveWidth) +
            Math.floor(offsetY / 150) * this.measuresPerLine;

        if (staveIndex < 0 || staveIndex >= this.numberOfMeasures) {
            console.warn("Kliknięcie poza obszarem taktu");
            return;
        }
        this.isRest = this.currentDuration.endsWith('r');


        const noteOptions = {
            keys: this.isRest ? ['b/4'] : [noteName + (this.currentAccidental || '')],
            duration: this.currentDuration,
        };


        const note = new StaveNote(noteOptions);
        console.log(noteOptions)

        if (this.currentAccidental && !this.isRest) {
            note.addAccidental(0, new Vex.Flow.Accidental(this.currentAccidental));
        }




        if (!this.notes[staveIndex]) this.notes[staveIndex] = [];
        const noteId = `note-${staveIndex}-${this.notes[staveIndex].length}`;
        note.customId = noteId;



        this.notes[staveIndex].push(note);



        this.renderNotes();


    }
    renderNotes() {
        const staveHeight = 150;


        this.context.clearRect(0, 0, this.measuresPerLine * 400 + 20, staveHeight * Math.ceil(this.numberOfMeasures / this.measuresPerLine));


        this.staves.forEach(stave => stave.setContext(this.context).draw());


        this.staves.forEach((stave, index) => {
            if (!this.notes[index] || this.notes[index].length === 0) return;

            const totalTicks = this.notes[index].reduce((sum, note) => sum + note.getTicks().value(), 0);
            const voice = new Voice({
                num_beats: totalTicks / Vex.Flow.RESOLUTION,
                beat_value: 1,
                mode: Voice.Mode.SOFT,
            });

            voice.addTickables(this.notes[index]);

            const formatter = new Formatter().joinVoices([voice]).format([voice], stave.width - 50);
            voice.draw(this.context, stave);
        });
    }

    initNoteCursor() {
        this.noteCursor = document.createElement('div');
        this.noteCursor.classList.add('note');
        document.body.appendChild(this.noteCursor);

        const updateCursorPosition = (event) => {
            if (this.activeNote) {
                this.noteCursor.style.left = `${event.clientX - 5}px`;
                this.noteCursor.style.top = `${event.clientY - 40 + window.scrollY}px`;
            }
        };

        document.addEventListener('mousemove', updateCursorPosition);
        document.addEventListener('scroll', () => {
            if (this.activeNote) {
                const rect = this.noteCursor.getBoundingClientRect();
                this.noteCursor.style.top = `${rect.top + window.scrollY}px`;
            }
        });
    }

    setNoteCursor(unicodeNote) {
        this.activeNote = unicodeNote;
        this.noteCursor.innerHTML = unicodeNote;
        this.noteCursor.style.display = 'block';
    }

    resetCursor() {
        this.activeNote = null;
        this.noteCursor.style.display = 'none';
    }
    changeMetrum(newSignature) {
        this.staves.forEach((stave, index) => {
            stave.modifiers = stave.modifiers.filter(mod => !(mod instanceof Vex.Flow.TimeSignature));

            if (index % 3 === 0) {
                stave.addTimeSignature(newSignature);
            }
        });
        this.renderNotes();
    }



    deleteLastNote() {
        for (let i = this.notes.length - 1; i >= 0; i--) {
            if (this.notes[i] && this.notes[i].length > 0) {
                this.notes[i].pop();
                this.renderNotes();
                return;
            }
        }
    }

}


const musicSheet = new Staff('stave', 24, 3);

document.getElementById('stave').addEventListener('click', function (event) {
    musicSheet.addNoteOnClick(event);
});

document.addEventListener('keydown', function (event) {
    const keyMapping = {
        '1': { duration: '1', symbol: '&#x1D15D;' },
        '2': { duration: '2', symbol: '&#x1D15E;' },
        '3': { duration: '4', symbol: '&#x1D15F;' },
        '4': { duration: '8', symbol: '&#x1D160;' },
        '5': { duration: '16', symbol: '&#x1D161;' },
        'q': { duration: '1r', symbol: '&#x1D13B;' }, // Całopauza
        'w': { duration: '2r', symbol: '&#x1D13C;' }, // Półpauza
        'e': { duration: '4r', symbol: '&#x1D13D;' }, // Ćwierćpauza
        'r': { duration: '8r', symbol: '&#x1D13E;' }, // Ósemkowa pauza
        't': { duration: '16r', symbol: '&#x1D13F;' }, // Szesnastkowa pauza
        'a': { accidental: '#', symbol: '&#x266F;' }, // Krzyżyk
        's': { accidental: 'b', symbol: '&#x266D;' }, // Bemol
        'd': { accidental: 'n', symbol: '&#x266E;' }, // Kasownik
    };

    if (keyMapping[event.key]) {
        const mapping = keyMapping[event.key];

        if (mapping.duration) {
            musicSheet.currentDuration = mapping.duration;
            musicSheet.setNoteCursor(mapping.symbol);
            document.querySelectorAll(".note-btn").forEach(btn => {
                btn.classList.remove("active-btn");
                if (btn.getAttribute("data-duration") === mapping.duration) {
                    btn.classList.add("active-btn");
                }
            });
        }

        if (mapping.accidental) {
            if (musicSheet.currentAccidental === mapping.accidental) {
                musicSheet.currentAccidental = null;
                musicSheet.setNoteCursor('');
                document.querySelectorAll(".accidental-btn").forEach(btn => {
                    btn.classList.remove("active-btn");
                });
            } else {
                musicSheet.currentAccidental = mapping.accidental;
                musicSheet.setNoteCursor(mapping.symbol);
                document.querySelectorAll(".accidental-btn").forEach(btn => {
                    btn.classList.remove("active-btn");
                    if (btn.getAttribute("data-accidental") === mapping.accidental) {
                        btn.classList.add("active-btn");
                    }
                });
            }
        }
    }

    if (event.key === 'Escape') {
        musicSheet.resetCursor();
        musicSheet.currentAccidental = null;
        document.querySelectorAll(".note-btn").forEach(btn => {
            btn.classList.remove("active-btn");
        });
        document.querySelectorAll(".accidental-btn").forEach(btn => {
            btn.classList.remove("active-btn");
        });
        musicSheet.notes=[]
        musicSheet.renderNotes()
    }
});


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".note-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.querySelectorAll(".note-btn").forEach(btn => {
                btn.classList.remove("active-btn");
            });
            this.classList.add("active-btn");
            const duration = this.getAttribute("data-duration");
            const symbol = this.getAttribute("data-symbol");
            musicSheet.currentDuration = duration;
            musicSheet.setNoteCursor(symbol);
        });
    });

    document.querySelectorAll(".accidental-btn").forEach(button => {
        button.addEventListener("click", function () {
            const accidental = this.getAttribute("data-accidental");


            if (musicSheet.currentAccidental === accidental) {

                musicSheet.currentAccidental = null;
                musicSheet.setNoteCursor('');
                document.querySelectorAll(".accidental-btn").forEach(btn => {
                    btn.classList.remove("active-btn");
                });
            } else {

                document.querySelectorAll(".accidental-btn").forEach(btn => {
                    btn.classList.remove("active-btn");
                });
                this.classList.add("active-btn");
                const symbol = this.getAttribute("data-symbol");
                musicSheet.currentAccidental = accidental;
                musicSheet.setNoteCursor(symbol);
            }
        });
    });

    document.getElementById("reset-btn").addEventListener("click", function () {
        musicSheet.resetCursor();
        musicSheet.currentAccidental = null;
        document.querySelectorAll(".note-btn").forEach(btn => {
            btn.classList.remove("active-btn");
        });
        document.querySelectorAll(".accidental-btn").forEach(btn => {
            btn.classList.remove("active-btn");
        });
        musicSheet.notes = []
        musicSheet.renderNotes()
    });


    document.getElementById("changeMetrum").addEventListener("click", function () {
        const newMetrum = prompt("Podaj metrum (np. 3/4, 6/8):");
        if (newMetrum) {
            musicSheet.changeMetrum(newMetrum);
        }
    });
    document.getElementById("delete-last-note").addEventListener("click", function () {
        musicSheet.deleteLastNote();
    });
    document.addEventListener("keydown", function (event) {
        if (event.key === "Backspace") {
            musicSheet.deleteLastNote();
        }
    });


});

