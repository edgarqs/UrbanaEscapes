let currentDate = new Date();

function generateWeekCalendar(date) {
    const startOfWeek = new Date(date);
    startOfWeek.setDate(date.getDate() - 5); 
    const weekDays = [];

    for (let i = 0; i < 31; i++) {
        const day = new Date(startOfWeek);
        day.setDate(startOfWeek.getDate() + i);
        weekDays.push(day);
    }

    const headerRow = document.querySelector('#headerRow');
    headerRow.innerHTML = ''; 

    const emptyHeaderCell = document.createElement('th');
    headerRow.appendChild(emptyHeaderCell);

    weekDays.forEach(day => {
        const headerCell = document.createElement('th');
        headerCell.textContent = `${day.toLocaleString('en-us', { weekday: 'short' })} ${day.getDate()}`; // Día y número
        headerRow.appendChild(headerCell);
    });

    refreshCalendarBody(startOfWeek);
}

function refreshCalendarBody(startDate) {
    const hotelId = document.querySelector('meta[name="hotel-id"]').getAttribute('content');
    fetch(`/refresh-calendar?start_date=${startDate.toISOString().split('T')[0]}&id=${hotelId}`)
        .then(response => response.json())
        .then(data => {
            const calendarBody = document.querySelector('#calendarBody');
            calendarBody.innerHTML = '';

            data.habitacions.forEach(habitacio => {
                const row = document.createElement('tr');
                const cell = document.createElement('td');
                cell.textContent = habitacio.numHabitacion;
                row.appendChild(cell);

                let remainingDays = Array.from({ length: 31 }, (_, i) => new Date(data.startDate).setDate(new Date(data.startDate).getDate() + i));

                while (remainingDays.length > 0) {
                    const currentDay = new Date(remainingDays.shift());
                    const reserva = data.reservas.find(r => r.habitacion_id === habitacio.id && new Date(r.data_entrada) <= currentDay && currentDay <= new Date(r.data_sortida).setDate(new Date(r.data_sortida).getDate() - 1));

                    let colspan = 1;
                    if (reserva) {
                        colspan = remainingDays.findIndex(day => new Date(day) > new Date(reserva.data_sortida).setDate(new Date(reserva.data_sortida).getDate() - 1)) + 1;
                        if (colspan === 0) colspan = remainingDays.length + 1;
                        remainingDays = remainingDays.slice(colspan - 1);
                    }

                    const cell = document.createElement('td');
                    cell.className = `reservation-cell ${reserva ? 'reserved' : 'available'}`;
                    cell.colSpan = colspan;
                    if (reserva) {
                        const details = document.createElement('div');
                        details.className = 'reservation-details';
                        details.innerHTML = `<p>${reserva.usuari.nom}</p>`;
                        cell.appendChild(details);
                    }
                    row.appendChild(cell);
                }

                calendarBody.appendChild(row);
            });
        });
}

document.querySelector('#prevWeek').addEventListener('click', () => {
    currentDate.setDate(currentDate.getDate() - 12);
    generateWeekCalendar(currentDate);
});

document.querySelector('#nextWeek').addEventListener('click', () => {
    currentDate.setDate(currentDate.getDate() + 12);
    generateWeekCalendar(currentDate);
});

generateWeekCalendar(currentDate);