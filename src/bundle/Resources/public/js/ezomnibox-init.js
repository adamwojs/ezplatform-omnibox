((global, doc, eZ) => {
    const OMNIBOX_INPUT_SELECTOR = '#omnibox input, [data-enable-omnibox]';

    const attachSpeechRecognizer = (input, onResult) => {
        const SpeechRecognition = global.SpeechRecognition || global.webkitSpeechRecognition;

        if (SpeechRecognition === undefined) {
            // Web Speech API is undefined
            return ;
        }

        const recognizer = new SpeechRecognition();
        recognizer.continuous = true;
        recognizer.interimResults = false
        recognizer.onresult = onResult;

        input.addEventListener('blur', (e) => {
            recognizer.stop()
        });

        input.addEventListener('focus', (e) => {
            recognizer.start();
        });
    }

    doc.addEventListener('DOMContentLoaded', () => {
        doc.querySelectorAll(OMNIBOX_INPUT_SELECTOR).forEach((input) => {
            const search = autocomplete(input, {
                openOnFocus: true,
                hint: true
            }, eZ.omnibox.getProviders());

            search.on('autocomplete:selected', (e, suggestion, dataset) => {
                if (suggestion && suggestion.actionUrl.length !== 0) {
                    global.location = suggestion.actionUrl;
                }
            });

            if (eZ.omnibox.isVoiceAssistantEnabled()) {
                attachSpeechRecognizer(input, (event) => {
                    for (let i = event.resultIndex; i < event.results.length; i++) {
                        const result = event.results[i];
                        if (result.isFinal) {
                            search.autocomplete.setVal(search.autocomplete.getVal() +  ' ' + result[0].transcript);
                        }
                    }
                });
            }

            doc.addEventListener('keydown', (e) => {
                if (e.altKey && e.key === '/') {
                    input.focus();
                }
            });
        });
    });
})(window, window.document, window.eZ);
