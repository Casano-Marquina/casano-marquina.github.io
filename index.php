<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Probador virtual con detección facial y corporal</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #0f172a;
            --panel: rgba(15, 23, 42, 0.86);
            --panel-strong: rgba(30, 41, 59, 0.94);
            --accent: #22d3ee;
            --accent-strong: #0891b2;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --danger: #fb7185;
            --ok: #34d399;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(34, 211, 238, 0.2), transparent 34rem),
                linear-gradient(135deg, #020617 0%, #0f172a 54%, #111827 100%);
        }

        main {
            width: min(1180px, calc(100% - 2rem));
            margin: 0 auto;
            padding: 2rem 0;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 1.5rem;
            align-items: stretch;
        }

        .stage,
        .controls,
        .tips {
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 24px;
            background: var(--panel);
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.28);
            backdrop-filter: blur(16px);
        }

        .stage {
            position: relative;
            overflow: hidden;
            min-height: 620px;
        }

        .stage-header {
            position: absolute;
            top: 1rem;
            left: 1rem;
            right: 1rem;
            z-index: 3;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            pointer-events: none;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 0.8rem;
            border-radius: 999px;
            background: rgba(2, 6, 23, 0.72);
            color: var(--text);
            font-size: 0.9rem;
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.2);
        }

        .status-pill::before {
            content: "";
            width: 0.65rem;
            height: 0.65rem;
            border-radius: 999px;
            background: var(--danger);
            box-shadow: 0 0 20px var(--danger);
        }

        .status-pill.ready::before {
            background: var(--ok);
            box-shadow: 0 0 20px var(--ok);
        }

        video,
        canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        video {
            transform: scaleX(-1);
            background: #020617;
        }

        canvas {
            z-index: 2;
        }

        .empty-camera {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: grid;
            place-items: center;
            padding: 2rem;
            text-align: center;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.72), rgba(2, 6, 23, 0.92));
        }

        .empty-camera.hidden {
            display: none;
        }

        .empty-camera h1 {
            max-width: 620px;
            margin: 0 auto 1rem;
            font-size: clamp(2rem, 5vw, 4.25rem);
            line-height: 0.95;
            letter-spacing: -0.055em;
        }

        .empty-camera p {
            max-width: 620px;
            margin: 0 auto;
            color: var(--muted);
            font-size: 1.08rem;
        }

        .controls {
            padding: 1.2rem;
        }

        .controls h2,
        .tips h2 {
            margin: 0 0 0.75rem;
            font-size: 1.05rem;
            letter-spacing: 0.01em;
        }

        .control-group {
            display: grid;
            gap: 0.8rem;
            padding: 1rem 0;
            border-top: 1px solid rgba(148, 163, 184, 0.16);
        }

        .control-group:first-of-type {
            border-top: 0;
            padding-top: 0.25rem;
        }

        label {
            display: grid;
            gap: 0.4rem;
            color: var(--muted);
            font-size: 0.88rem;
        }

        select,
        input[type="range"],
        input[type="file"],
        button {
            width: 100%;
        }

        select,
        input[type="file"] {
            padding: 0.7rem;
            border: 1px solid rgba(148, 163, 184, 0.26);
            border-radius: 14px;
            color: var(--text);
            background: rgba(15, 23, 42, 0.9);
        }

        button {
            border: 0;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            color: #042f2e;
            background: linear-gradient(135deg, var(--accent), #67e8f9);
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 12px 32px rgba(34, 211, 238, 0.22);
        }

        button.secondary {
            color: var(--text);
            background: rgba(30, 41, 59, 0.95);
            box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.24);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .tips {
            margin-top: 1.5rem;
            padding: 1.2rem;
        }

        .tips ul {
            margin: 0;
            padding-left: 1.2rem;
            color: var(--muted);
            line-height: 1.7;
        }

        .hint {
            margin: 0;
            color: var(--muted);
            font-size: 0.88rem;
            line-height: 1.5;
        }

        .metric {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .metric strong {
            color: var(--text);
        }

        @media (max-width: 920px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .stage {
                min-height: 70vh;
            }
        }
    </style>
</head>
<body>
    <main>
        <section class="hero" aria-label="Probador virtual">
            <div class="stage">
                <video id="camera" playsinline muted></video>
                <canvas id="overlay"></canvas>
                <div class="stage-header">
                    <span id="faceStatus" class="status-pill">Rostro no detectado</span>
                    <span id="bodyStatus" class="status-pill">Cuerpo no detectado</span>
                </div>
                <div id="emptyCamera" class="empty-camera">
                    <div>
                        <h1>Probador virtual con rostro y cuerpo</h1>
                        <p>Activa la cámara, ubícate de frente y sube prendas en PNG/JPG. Los lentes y gorros se ajustan al rostro; las camisetas se ajustan a hombros, cuello y cadera.</p>
                    </div>
                </div>
            </div>

            <aside class="controls" aria-label="Controles del probador">
                <h2>Controles</h2>
                <div class="control-group">
                    <button id="startCamera" type="button">Activar cámara</button>
                    <button id="clearGarments" class="secondary" type="button">Quitar prendas</button>
                    <p class="hint">Si el navegador pide permiso, acepta la cámara. En celulares usa buena luz y mantén el teléfono vertical.</p>
                </div>

                <div class="control-group">
                    <label>
                        Tipo de prenda
                        <select id="garmentType">
                            <option value="glasses">Lentes / gafas</option>
                            <option value="hat">Gorra / sombrero / birrete</option>
                            <option value="shirt">Camisa / camiseta / polo</option>
                        </select>
                    </label>
                    <label>
                        Subir imagen de prenda
                        <input id="garmentFile" type="file" accept="image/*">
                    </label>
                    <p class="hint">Recomendado: PNG con fondo transparente. Si tiene fondo negro/blanco, el ajuste funciona pero se verá el recuadro.</p>
                </div>

                <div class="control-group">
                    <label>
                        Escala manual
                        <input id="scaleControl" type="range" min="60" max="180" value="100">
                    </label>
                    <label>
                        Desplazamiento vertical
                        <input id="offsetControl" type="range" min="-80" max="80" value="0">
                    </label>
                    <div class="row">
                        <button id="useDemoGlasses" class="secondary" type="button">Demo lentes</button>
                        <button id="useDemoShirt" class="secondary" type="button">Demo camiseta</button>
                    </div>
                </div>

                <div class="control-group">
                    <div class="metric"><span>FPS</span><strong id="fpsValue">0</strong></div>
                    <div class="metric"><span>Confianza rostro</span><strong id="faceScore">0%</strong></div>
                    <div class="metric"><span>Confianza cuerpo</span><strong id="bodyScore">0%</strong></div>
                </div>
            </aside>
        </section>

        <section class="tips">
            <h2>Por qué antes no se superponía correctamente</h2>
            <ul>
                <li>Una imagen de prenda por sí sola no reconoce personas: se necesita un detector de puntos faciales y corporales.</li>
                <li>Los lentes se posicionan con ojos y nariz; las gorras con frente, sienes y parte superior de la cara; las camisetas con hombros, cuello y caderas.</li>
                <li>Si sales de lado, estás muy lejos o falta luz, el modelo pierde puntos y la prenda no se dibuja para evitar quedar flotando.</li>
            </ul>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/pose/pose.js" crossorigin="anonymous"></script>
    <script>
        const video = document.getElementById('camera');
        const canvas = document.getElementById('overlay');
        const ctx = canvas.getContext('2d');
        const emptyCamera = document.getElementById('emptyCamera');
        const faceStatus = document.getElementById('faceStatus');
        const bodyStatus = document.getElementById('bodyStatus');
        const fpsValue = document.getElementById('fpsValue');
        const faceScore = document.getElementById('faceScore');
        const bodyScore = document.getElementById('bodyScore');
        const garmentType = document.getElementById('garmentType');
        const garmentFile = document.getElementById('garmentFile');
        const scaleControl = document.getElementById('scaleControl');
        const offsetControl = document.getElementById('offsetControl');

        const state = {
            faceLandmarks: null,
            poseLandmarks: null,
            activeGarments: new Map(),
            camera: null,
            lastFrameTime: performance.now(),
            busy: false
        };

        const faceMesh = new FaceMesh({
            locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
        });
        faceMesh.setOptions({
            maxNumFaces: 1,
            refineLandmarks: true,
            minDetectionConfidence: 0.55,
            minTrackingConfidence: 0.55
        });
        faceMesh.onResults(results => {
            state.faceLandmarks = results.multiFaceLandmarks?.[0] ?? null;
            updateStatus();
        });

        const pose = new Pose({
            locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/pose/${file}`
        });
        pose.setOptions({
            modelComplexity: 1,
            smoothLandmarks: true,
            enableSegmentation: false,
            minDetectionConfidence: 0.55,
            minTrackingConfidence: 0.55
        });
        pose.onResults(results => {
            state.poseLandmarks = results.poseLandmarks ?? null;
            updateStatus();
        });

        const demos = {
            glasses: svgImage(`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 220"><g fill="none" stroke="#111827" stroke-width="22" stroke-linecap="round" stroke-linejoin="round"><path d="M118 52h138c43 0 78 35 78 78s-35 78-78 78H118c-43 0-78-35-78-78s35-78 78-78Z" fill="#243b68" fill-opacity=".72"/><path d="M384 52h138c43 0 78 35 78 78s-35 78-78 78H384c-43 0-78-35-78-78s35-78 78-78Z" fill="#243b68" fill-opacity=".72"/><path d="M326 116c22-22 42-22 64 0"/><path d="M40 92 6 76M600 92l34-16"/></g></svg>`),
            shirt: svgImage(`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 760"><path d="M214 72h212l142 78 50 132-96 42-34-72v430c0 34-28 62-62 62H214c-34 0-62-28-62-62V252l-34 72-96-42 50-132 142-78Z" fill="#f8fafc"/><path d="M214 72c18 58 194 58 212 0v92c-40 36-172 36-212 0V72Z" fill="#e2e8f0"/><text x="320" y="300" text-anchor="middle" font-size="54" font-family="Arial" font-weight="800" fill="#0f172a">TU PRENDA</text></svg>`)
        };

        document.getElementById('startCamera').addEventListener('click', startCamera);
        document.getElementById('clearGarments').addEventListener('click', () => {
            state.activeGarments.clear();
            garmentFile.value = '';
            drawOverlay();
        });
        document.getElementById('useDemoGlasses').addEventListener('click', () => setGarment('glasses', demos.glasses));
        document.getElementById('useDemoShirt').addEventListener('click', () => setGarment('shirt', demos.shirt));
        garmentFile.addEventListener('change', event => {
            const file = event.target.files?.[0];
            if (!file) return;
            const image = new Image();
            image.onload = () => setGarment(garmentType.value, image);
            image.src = URL.createObjectURL(file);
        });
        scaleControl.addEventListener('input', drawOverlay);
        offsetControl.addEventListener('input', drawOverlay);

        async function startCamera() {
            emptyCamera.classList.add('hidden');
            if (state.camera) {
                return;
            }
            state.camera = new Camera(video, {
                width: 1280,
                height: 720,
                facingMode: 'user',
                onFrame: async () => {
                    if (state.busy) return;
                    state.busy = true;
                    await Promise.all([faceMesh.send({ image: video }), pose.send({ image: video })]);
                    calculateFps();
                    resizeCanvas();
                    drawOverlay();
                    state.busy = false;
                }
            });
            await state.camera.start();
        }

        function setGarment(type, image) {
            state.activeGarments.set(type, image);
            garmentType.value = type;
            drawOverlay();
        }

        function resizeCanvas() {
            const { width, height } = canvas.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;
            const nextWidth = Math.round(width * dpr);
            const nextHeight = Math.round(height * dpr);
            if (canvas.width !== nextWidth || canvas.height !== nextHeight) {
                canvas.width = nextWidth;
                canvas.height = nextHeight;
            }
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }

        function drawOverlay() {
            resizeCanvas();
            const rect = canvas.getBoundingClientRect();
            ctx.clearRect(0, 0, rect.width, rect.height);
            if (state.activeGarments.has('shirt')) drawShirt(rect);
            if (state.activeGarments.has('hat')) drawHat(rect);
            if (state.activeGarments.has('glasses')) drawGlasses(rect);
        }

        function drawGlasses(rect) {
            const points = state.faceLandmarks;
            const image = state.activeGarments.get('glasses');
            if (!points || !image) return;
            const leftEye = point(points[33], rect);
            const rightEye = point(points[263], rect);
            const nose = point(points[168], rect);
            const angle = Math.atan2(rightEye.y - leftEye.y, rightEye.x - leftEye.x);
            const eyeDistance = distance(leftEye, rightEye);
            const width = eyeDistance * 2.45 * scaleFactor();
            const height = width * (image.height / image.width);
            drawImageCentered(image, nose.x, nose.y + 8 + yOffset(), width, height, angle);
        }

        function drawHat(rect) {
            const points = state.faceLandmarks;
            const image = state.activeGarments.get('hat');
            if (!points || !image) return;
            const leftTemple = point(points[127], rect);
            const rightTemple = point(points[356], rect);
            const forehead = point(points[10], rect);
            const angle = Math.atan2(rightTemple.y - leftTemple.y, rightTemple.x - leftTemple.x);
            const width = distance(leftTemple, rightTemple) * 1.75 * scaleFactor();
            const height = width * (image.height / image.width);
            drawImageCentered(image, forehead.x, forehead.y - height * 0.22 + yOffset(), width, height, angle);
        }

        function drawShirt(rect) {
            const points = state.poseLandmarks;
            const image = state.activeGarments.get('shirt');
            if (!points || !image) return;
            const leftShoulder = visiblePoint(points[11], rect);
            const rightShoulder = visiblePoint(points[12], rect);
            const leftHip = visiblePoint(points[23], rect);
            const rightHip = visiblePoint(points[24], rect);
            if (!leftShoulder || !rightShoulder || !leftHip || !rightHip) return;

            const neck = midpoint(leftShoulder, rightShoulder);
            const hips = midpoint(leftHip, rightHip);
            const torsoHeight = distance(neck, hips) * 1.45;
            const shoulderWidth = distance(leftShoulder, rightShoulder);
            const width = shoulderWidth * 1.95 * scaleFactor();
            const height = Math.max(torsoHeight, width * (image.height / image.width));
            const angle = Math.atan2(rightShoulder.y - leftShoulder.y, rightShoulder.x - leftShoulder.x);
            drawImageCentered(image, neck.x, neck.y + height * 0.42 + yOffset(), width, height, angle);
        }

        function drawImageCentered(image, x, y, width, height, angle = 0) {
            ctx.save();
            ctx.translate(x, y);
            ctx.rotate(angle);
            ctx.drawImage(image, -width / 2, -height / 2, width, height);
            ctx.restore();
        }

        function point(landmark, rect) {
            return {
                x: rect.width - landmark.x * rect.width,
                y: landmark.y * rect.height,
                visibility: landmark.visibility ?? 1
            };
        }

        function visiblePoint(landmark, rect) {
            const p = point(landmark, rect);
            return p.visibility >= 0.45 ? p : null;
        }

        function midpoint(a, b) {
            return { x: (a.x + b.x) / 2, y: (a.y + b.y) / 2 };
        }

        function distance(a, b) {
            return Math.hypot(a.x - b.x, a.y - b.y);
        }

        function scaleFactor() {
            return Number(scaleControl.value) / 100;
        }

        function yOffset() {
            return Number(offsetControl.value);
        }

        function updateStatus() {
            const faceDetected = Boolean(state.faceLandmarks);
            const bodyConfidence = averageVisibility([11, 12, 23, 24].map(i => state.poseLandmarks?.[i]).filter(Boolean));
            const bodyDetected = bodyConfidence >= 0.45;
            faceStatus.textContent = faceDetected ? 'Rostro detectado' : 'Rostro no detectado';
            bodyStatus.textContent = bodyDetected ? 'Cuerpo detectado' : 'Cuerpo no detectado';
            faceStatus.classList.toggle('ready', faceDetected);
            bodyStatus.classList.toggle('ready', bodyDetected);
            faceScore.textContent = faceDetected ? '100%' : '0%';
            bodyScore.textContent = `${Math.round(bodyConfidence * 100)}%`;
        }

        function averageVisibility(points) {
            if (!points.length) return 0;
            return points.reduce((sum, p) => sum + (p.visibility ?? 1), 0) / points.length;
        }

        function calculateFps() {
            const now = performance.now();
            const fps = 1000 / Math.max(1, now - state.lastFrameTime);
            fpsValue.textContent = Math.round(fps);
            state.lastFrameTime = now;
        }

        function svgImage(source) {
            const image = new Image();
            image.src = `data:image/svg+xml;charset=utf-8,${encodeURIComponent(source)}`;
            return image;
        }

        window.addEventListener('resize', drawOverlay);
    </script>
</body>
</html>
