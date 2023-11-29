const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
let circleX = canvas.width / 2;
let circleY = canvas.height / 2;
let circleRadius = 20;
const websocket = new WebSocket('ws://[サーバーのIPアドレス]:8080');

function drawCircle() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.beginPath();
    ctx.arc(circleX, circleY, circleRadius, 0, Math.PI * 2);
    ctx.fillStyle = 'blue';
    ctx.fill();
    ctx.closePath();
}

function updateCircleSize(acceleration) {
    const accelerationMagnitude = Math.sqrt(acceleration.x ** 2 + acceleration.y ** 2);
    if (accelerationMagnitude > 5) {
        circleRadius += 5;
    }
    websocket.send(JSON.stringify({ x: acceleration.x, y: acceleration.y }));
}

function setupDeviceMotion() {
    window.addEventListener('devicemotion', (event) => {
        updateCircleSize({
            x: event.acceleration.x,
            y: event.acceleration.y
        });
        drawCircle();
    });
}

function requestPermission() {
    if (typeof DeviceMotionEvent.requestPermission === 'function') {
        DeviceMotionEvent.requestPermission()
            .then(permissionState => {
                if (permissionState === 'granted') {
                    setupDeviceMotion();
                } else {
                    alert('加速度センサーへのアクセスが許可されていません。');
                }
            })
            .catch(console.error);
    } else {
        setupDeviceMotion();
    }
}

document.getElementById('permissionButton').addEventListener('click', function () {
    requestPermission();
});

document.getElementById('resetButton').addEventListener('click', function () {
    circleRadius = 20;
    drawCircle();
});

drawCircle();
