
const birthDate = new Date('2008-08-08T00:00:00');
const circle = document.querySelector('.radial-bar .progress');
const circumference = 2 * Math.PI * 45;
circle.style.strokeDasharray = circumference;

function updateAge() {
    const now = new Date();
    const diff = now - birthDate;
    const miliseconds = Math.floor(diff);
    const seconds = Math.floor(miliseconds / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor(days / (365.25 / 12));
    const years = diff / (365.25 * 24 * 60 * 60 * 1000);

    document.getElementById('years-old').textContent = years.toFixed(2);


    const thisYearBday = new Date(now.getFullYear(), birthDate.getMonth(), birthDate.getDate());
    let lastBday, nextBday;
    if (now >= thisYearBday) {
        lastBday = thisYearBday;
        nextBday = new Date(now.getFullYear() + 1, birthDate.getMonth(), birthDate.getDate());
    } else {
        lastBday = new Date(now.getFullYear() - 1, birthDate.getMonth(), birthDate.getDate());
        nextBday = thisYearBday;
    }

    const yearSpan = nextBday - lastBday;
    const elapsed = now - lastBday;
    const percent = elapsed / yearSpan;
    const offset = circumference * (1 - percent);

    circle.style.strokeDashoffset = offset;

    document.getElementById('months-old').textContent = months;
    document.getElementById('days-old').textContent = days;
    document.getElementById('hours-old').textContent = hours;
    document.getElementById('minutes-old').textContent = minutes;
    document.getElementById('seconds-old').textContent = seconds;
    document.getElementById('miliseconds-old').textContent = miliseconds;
}

updateAge();
setInterval(updateAge, 1);