const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
const daysOfWeek = ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"];

let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();

const monthElement = document.getElementById('month');
const daysElement = document.getElementById('days');
const prevMonthBtn = document.getElementById('prevMonthBtn');
const nextMonthBtn = document.getElementById('nextMonthBtn');

function generateCalendar(month, year) {
    
    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    monthElement.textContent = `${monthNames[month]} ${year}`;

    let calendarHTML = '';
    
    for (let i = 0; i < daysOfWeek.length; i++) {
        calendarHTML += `<div>${daysOfWeek[i]}</div>`;
    }

    for (let i = 0; i < (firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1); i++) {
        calendarHTML += `<div></div>`;
    }

    for (let i = 1; i <= daysInMonth; i++) {
        if (i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
            calendarHTML += `<div class="current-day">${i}</div>`;
        } else {
            let classNames = "";
            const lastWeekStart = daysInMonth - 7;
            if (i > lastWeekStart) {
                classNames = "last-week";
            }
            calendarHTML += `<div class="${classNames}">${i}</div>`;
        }
    }

    daysElement.innerHTML = calendarHTML;
}

generateCalendar(currentMonth, currentYear);

// Instanciation des bouttons suivant et précendent

prevMonthBtn.addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar(currentMonth, currentYear);
});

nextMonthBtn.addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar(currentMonth, currentYear);
});

const dayOfWeekElement = document.getElementById('dayOfWeek');
const dayOfMonthElement = document.getElementById('dayOfMonth');
const monthNameElement = document.getElementById('monthName');
const infoElement = document.getElementById('info');

const currentDate = new Date();

const dayOfWeek = currentDate.getDay();
const dayOfWeekNames = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
const dayOfWeekName = dayOfWeekNames[dayOfWeek];

const dayOfMonth = currentDate.getDate();

const month = currentDate.getMonth();
const monthName = monthNames[month];

const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

dayOfWeekElement.textContent = dayOfWeekName;
dayOfMonthElement.textContent = dayOfMonth;
monthNameElement.textContent = monthName;

if (dayOfMonth <= lastDayOfMonth - 7) {
    infoElement.textContent = "Phase de participation en cours";
} else {
    infoElement.textContent = "Phase de vote en cours";
}

const redirectButton = document.getElementById('formulaire');
const isParticipationPhase = dayOfMonth <= lastDayOfMonth - 7;

if (isParticipationPhase) {
    infoElement.textContent = "Phase de participation en cours";
    redirectButton.textContent = "Participer";
    redirectButton.addEventListener('click', () => {
        window.location.href = 'participer.html';
    });
} else {
    infoElement.textContent = "Phase de vote en cours";
    redirectButton.textContent = "Voter";
    redirectButton.addEventListener('click', () => {
        window.location.href = 'voter.html';
    });
}