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
        headerCell.className = 'th-day';
        headerCell.textContent = `${day.toLocaleString('es', { weekday: 'short' })} ${day.getDate()}`;
        headerRow.appendChild(headerCell);
    });

    refreshCalendarBody(startOfWeek);
}

function fetchCalendarData(startDate, hotelId) {
    return fetch(`/refresh-calendar?start_date=${startDate.toISOString().split('T')[0]}&id=${hotelId}`)
        .then(response => response.json())
        .catch(error => {
            // console.error('Error fetching calendar data:', error);
            throw error;
        });
}

function renderCalendar(data) {
    const calendarBody = document.querySelector('#calendarBody');
    calendarBody.innerHTML = '';

    data.habitacions.forEach(habitacio => {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.onclick = () => {
            window.location.href = `/reserves/${habitacio.numHabitacion}`;
        }
        const link = document.createElement('a');
        cell.textContent = habitacio.numHabitacion;
        
        cell.appendChild(link);

        row.appendChild(cell);

        let remainingDays = Array.from({ length: 31 }, (_, i) => {
            const day = new Date(data.startDate);
            day.setDate(day.getDate() + i);
            return day;
        });

        while (remainingDays.length > 0) {
            const currentDay = new Date(remainingDays.shift());
            const reserva = data.reservas.find(r => {
                const entrada = new Date(r.data_entrada);
                const sortida = new Date(r.data_sortida);
                const current = new Date(currentDay);
                return r.habitacion_id === habitacio.id && entrada <= current && current <= sortida;
            });

            let colspan = 1;
            if (reserva) {
                colspan = remainingDays.findIndex(day => 
                    new Date(day) > new Date(reserva.data_sortida)
                ) + 1;

                if (colspan === 0) colspan = remainingDays.length + 1;
                remainingDays = remainingDays.slice(colspan - 1);
            }

            const cell = document.createElement('td');
            cell.className = `reservation-cell ${reserva ? 'reserved' : 'available'} fixed-width-cell`;
            cell.addEventListener('click', () => {
                if (reserva) {
                    fetch(`/habitacions/${habitacio.id}/detalls`)
                        .then(response => response.text())
                        .then(data => {
                            document.querySelector("#popup-details").innerHTML = data;
                            document.querySelector("#popup").style.display = "grid";
                        })
                        // .catch(error => console.error('Error:', error));
                }else{
                    window.location.href = `/reserves/${habitacio.numHabitacion}`;
                }
            }
            );
            cell.colSpan = colspan;

            if (reserva) {
                const details = document.createElement('div');
                details.className = 'reservation-details';
                const usuari = data.usuaris.find(u => u.id === reserva.usuari_id); 
                details.innerHTML = `<p>${usuari ? usuari.nom : reserva.usuari_id}</p>`;
                cell.appendChild(details);
            }
            
            row.appendChild(cell);
        }

        calendarBody.appendChild(row);
    });
}

function refreshCalendarBody(startDate) {
    const hotelId = document.querySelector('meta[name="hotel-id"]').getAttribute('content');
    
    fetchCalendarData(startDate, hotelId)
        .then(data => {
            // console.log('Data received:', data); // Verificar los datos recibidos
            renderCalendar(data);
        })
        // .catch(error => console.error('Error fetching calendar data:', error));
}

document.querySelector('#prevWeek').addEventListener('click', () => {
    currentDate.setDate(currentDate.getDate() - 7);
    generateWeekCalendar(currentDate);
});

document.querySelector('#nextWeek').addEventListener('click', () => {
    currentDate.setDate(currentDate.getDate() + 7);
    generateWeekCalendar(currentDate);
});

generateWeekCalendar(currentDate);