<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to Text</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        #result {
            border: 2px dashed #764ba2;
            padding: 20px;
            height: 200px;
            width: 100%;
            margin-bottom: 20px;
            background: linear-gradient(168deg, #ff9a9e, #fad0c4);
            border-radius: 5px;
            font-size: 18px;
            overflow-y: auto;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        button {
            font-size: 24px;
            height: 70px;
            width: 70px;
            border-radius: 50%;
            background: linear-gradient(to bottom, #764ba2, #667eea);
            color: #fff;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: linear-gradient(to bottom, #667eea, #764ba2);
            transform: scale(1.1);
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Speech to Text Converter</h2>
        <div id="result"></div>
        <div class="button-container">
            <button onclick="startConverting()" id="mic-btn">
                <i class="fa fa-microphone"></i>
            </button>
            <button onclick="stopConverting()">
                <i class="fa fa-stop"></i>
            </button>
        </div>
    </div>

    <script>
        const resultElement = document.getElementById("result");
        let recognition;

        function startConverting() {
            if ('webkitSpeechRecognition' in window) {
                recognition = new webkitSpeechRecognition();
                setupRecognition(recognition);
                recognition.start();
                document.getElementById("mic-btn").style.animation = "blink 1s infinite";
            }
        }

        function setupRecognition(recognition) {
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = 'en-US';
            recognition.onresult = function(event) {
                const { finalTranscript, interTranscript } = processResult(event.results);
                resultElement.innerHTML = finalTranscript + interTranscript;
            }
        }

        function processResult(results) {
            let finalTranscript = '';
            let interTranscript = '';
            for (let i = 0; i < results.length; i++) {
                let transcript = results[i][0].transcript;
                transcript.replace("\n", "<br>");
                if (results[i].isFinal) {
                    finalTranscript += transcript + ' ';
                } else {
                    interTranscript += transcript;
                }
            }
            return { finalTranscript, interTranscript };
        }

        function stopConverting() {
            if (recognition) {
                recognition.stop();
                document.getElementById("mic-btn").style.animation = "none";
            }
        }
    </script>
</body>
</html>
