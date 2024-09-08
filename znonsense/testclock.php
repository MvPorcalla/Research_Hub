<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analog Clock</title>
    <style>
        :root {
            --main-bg-color: #e8dfec;
            --main-text-color: #888888;
        }

        [data-theme="dark"] {
            --main-bg-color: #1e1f26;
            --main-text-color: #ccc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            background-color: var(--main-bg-color);
            transition: all ease 0.2s;
        }

        .page-header {
            font-size: 2rem;
            color: var(--main-text-color);
            padding: 2rem 0;
            font-family: monospace;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .clock {
            position: relative;
            min-height: 18em;
            min-width: 18em;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--main-bg-color);
            background-image: url("https://imvpn22.github.io/analog-clock/clock.png");
            background-position: center;
            background-size: cover;
            border-radius: 50%;
            border: 4px solid var(--main-bg-color);
            box-shadow: 0 -15px 15px rgba(255, 255, 255, 0.05),
                        inset 0 -15px 15px rgba(255, 255, 255, 0.05),
                        0 15px 15px rgba(0, 0, 0, 0.3),
                        inset 0 15px 15px rgba(0, 0, 0, 0.3);
        }

        .clock:before {
            content: "";
            height: 0.75rem;
            width: 0.75rem;
            background-color: var(--main-text-color);
            border: 2px solid var(--main-bg-color);
            position: absolute;
            border-radius: 50%;
            z-index: 1000;
        }

        .hour, .min, .sec {
            position: absolute;
            display: flex;
            justify-content: center;
            border-radius: 50%;
        }

        .hour {
            height: 10em;
            width: 10em;
        }

        .hour:before {
            content: "";
            position: absolute;
            height: 50%;
            width: 6px;
            background-color: var(--main-text-color);
            border-radius: 6px;
        }

        .min {
            height: 12em;
            width: 12em;
        }

        .min:before {
            content: "";
            height: 50%;
            width: 4px;
            background-color: var(--main-text-color);
            border-radius: 4px;
        }

        .sec {
            height: 13em;
            width: 13em;
        }

        .sec:before {
            content: "";
            height: 60%;
            width: 2px;
            background-color: #f00;
            border-radius: 2px;
        }

        .switch-cont {
            margin: 2em auto;
        }

        .switch-btn {
            font-family: monospace;
            text-transform: uppercase;
            outline: none;
            padding: 0.5rem 1rem;
            background-color: var(--main-bg-color);
            color: var(--main-text-color);
            border: 1px solid var(--main-text-color);
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all ease 0.3s;
        }
    </style>
</head>
<body>
    <div class="page-header">Analog Clock ni MELVS shesh</div>
    <div class="clock">
        <div class="hour"></div>
        <div class="min"></div>
        <div class="sec"></div>
    </div>
    <div class="switch-cont">
        <button class="switch-btn">Light</button>
    </div>

    <script>
        const deg = 6;
        const hour = document.querySelector(".hour");
        const min = document.querySelector(".min");
        const sec = document.querySelector(".sec");

        // Function to set the clock hands
        const setClock = () => {
            let day = new Date();
            let hh = day.getHours() * 30;
            let mm = day.getMinutes() * deg;
            let ss = day.getSeconds() * deg;

            hour.style.transform = `rotateZ(${hh + mm / 12}deg)`;
            min.style.transform = `rotateZ(${mm}deg)`;
            sec.style.transform = `rotateZ(${ss}deg)`;
        };

        // Set clock immediately and update every second
        setClock();
        setInterval(setClock, 1000);

        // Theme switch logic
        const switchTheme = (evt) => {
            const switchBtn = evt.target;
            const currentTheme = document.documentElement.getAttribute("data-theme");

            if (currentTheme === "dark") {
                document.documentElement.setAttribute("data-theme", "light");
                switchBtn.textContent = "Dark";
                localStorage.setItem("theme", "light");
            } else {
                document.documentElement.setAttribute("data-theme", "dark");
                switchBtn.textContent = "Light";
                localStorage.setItem("theme", "dark");
            }
        };

        const switchModeBtn = document.querySelector(".switch-btn");
        switchModeBtn.addEventListener("click", switchTheme);

        // Load theme from localStorage
        const savedTheme = localStorage.getItem("theme") || "light";
        document.documentElement.setAttribute("data-theme", savedTheme);
        switchModeBtn.textContent = savedTheme === "dark" ? "Light" : "Dark";

    </script>
</body>
</html>
