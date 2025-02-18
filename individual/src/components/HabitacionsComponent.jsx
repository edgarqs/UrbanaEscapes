import React, { useState, useEffect } from "react";

export default function HabitacionsComponent() {
    const [habitacions, setHabitacions] = useState([]);
    const hotelId = import.meta.env.VITE_HOTEL_ID;
    const apiUrl = import.meta.env.DEV ? import.meta.env.VITE_DEV_API_URL : import.meta.env.VITE_PROD_API_URL;

    useEffect(() => {
        const fetchHabitacions = async () => {
            try {
                const response = await fetch(`${apiUrl}/v1/habitacions`);
                const data = await response.json();
                const filteredHabitacions = data.filter(
                    (habitacio) => habitacio.hotel.codi_hotel === hotelId
                );

                const uniqueHabitacions = [];
                const tipusSet = new Set();

                filteredHabitacions.forEach((habitacio) => {
                    if (!tipusSet.has(habitacio.tipus)) {
                        tipusSet.add(habitacio.tipus);
                        uniqueHabitacions.push(habitacio);
                    }
                });

                setHabitacions(uniqueHabitacions);
            } catch (error) {
                console.error("Error llistant habitacions:", error);
            }
        };

        fetchHabitacions();
    }, [apiUrl, hotelId]);

    return (
        <div className="habitacionsTipus">
            <h2 className="habitacionsTipus__title">Descobreix les nostres habitacions</h2>
            <div className="habitacionsTipus__cards">
                {habitacions.map((habitacio, index) => (
                    <div 
                        key={habitacio.id} 
                        className="habitacionsTipus__cards__card"
                        style={{ backgroundImage: `url(/img/habitacio-${index + 1}.jpg)` }}

                    >
                        <h3 className="habitacionsTipus__cards__card__title">{habitacio.tipus}</h3>
                        {/*<button className="habitacionsTipus__cards__card__btn">Reservar</button>*/}
                    </div>
                ))}
            </div>
        </div>
    );
}
