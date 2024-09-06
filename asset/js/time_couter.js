function updateTime() {
    var now = new Date();
    var hours = String(now.getHours()).padStart(2, '0');
    var minutes = String(now.getMinutes()).padStart(2, '0');
    var seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('time').innerText = 'ขณะนี้เวลา ' + hours + ':' + minutes + ':' + seconds;
}

setInterval(updateTime, 1000);
window.onload = updateTime;