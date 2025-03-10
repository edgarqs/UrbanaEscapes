import {useState, useEffect} from 'react';
import {useNavigate} from 'react-router-dom';

import estandarImg from '@/assets/habitacio-estandar.avif';
import deluxeImg from '@/assets/habitacio-deluxe.avif';
import suiteImg from '@/assets/habitacio-suite.avif';
import adaptadaImg from '@/assets/habitacio-adaptada.avif';

export default function HabitacionsComponent() {
	const [habitacions, setHabitacions] = useState([]);
	const [selectedHabitacio, setSelectedHabitacio] = useState(0);
	const [tipusHabitacions, setTipusHabitacions] = useState([]);
	const navigate = useNavigate();

	const habitacionsLocals = [
		{
			tipus: 'Estandar',
			descripcio:
				'La nostra habitació estàndar ofereix tot el necessari per a una estada còmoda i agradable. Amb un disseny modern i acollidor, és perfecta per a viatgers que busquen tranquil·litat i funcionalitat.',
			foto: estandarImg,
		},
		{
			tipus: 'Deluxe',
			descripcio:
				"L'habitació Deluxe és la combinació perfecta entre luxe i comoditat. Amb detalls d'alta gamma i un ambient relaxant, et sentiràs com a casa però amb un toc especial.",
			foto: deluxeImg,
		},
		{
			tipus: 'Suite',
			descripcio:
				"Viu una experiència de luxe a la nostra suite. Amb espaiós interiors, vista panoràmica i serveis exclusius, aquesta habitació és ideal per a qui busca un toc d'elegància i sofisticació.",
			foto: suiteImg,
		},
		{
			tipus: 'Adaptada',
			descripcio:
				"Pensada per a tothom, la nostra habitació adaptada ofereix accessibilitat sense renunciar a la comoditat i l'estil. Amb espais amplis i disseny funcional, és ideal per a persones amb mobilitat reduïda.",
			foto: adaptadaImg,
		},
	];

	useEffect(() => {
		const fetchTipusHabitacions = async () => {
			try {
				const apiUrl = import.meta.env.DEV
					? import.meta.env.VITE_DEV_API_URL
					: import.meta.env.VITE_PROD_API_URL;
				const codiHotel = import.meta.env.VITE_HOTEL_ID;
				const response = await fetch(
					`${apiUrl}/v2/hotels/${codiHotel}/tipos-habitaciones`
				);
				const data = await response.json();
				const tipus = data.map((habitacio) => habitacio.tipus);
				setTipusHabitacions(tipus);
			} catch (error) {
				console.error('Error:', error);
			}
		};

		fetchTipusHabitacions();
	}, []);

	useEffect(() => {
		const filteredHabitacions = habitacionsLocals.filter((habitacio) =>
			tipusHabitacions.includes(habitacio.tipus)
		);
		setHabitacions(filteredHabitacions);
	// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [tipusHabitacions]); //! Revisar: tipusHabitacions, habitacionsLocals da error en la consola

	const handleReservar = () => {
		navigate('/reserves');
	};

	return (
		<div className="habitacionsTipus">
			<h2 className="margin-top habitacionsTipus__title">
				Descobreix les nostres habitacions
			</h2>

			<div className="buttons">
				{habitacions.map((habitacio, index) => (
					<button
						key={index}
						className={`buttons__btn ${selectedHabitacio === index ? 'buttons__btn--active' : ''}`}
						onClick={() => setSelectedHabitacio(index)}>
						{habitacio.tipus}
					</button>
				))}
			</div>

			{/* Contenedor para la foto y la información de la habitación seleccionada */}
			<div className="habitacionsTipus__selected">
				<div
					className="habitacionsTipus__selected__photo"
					style={{
						backgroundImage: `url(${habitacions[selectedHabitacio]?.foto})`,
					}}></div>
				<div className="habitacionsTipus__selected__info">
					<h3 className="habitacionsTipus__selected__info__title font-primary">
						{habitacions[selectedHabitacio]?.tipus}
					</h3>
					<p className="habitacionsTipus__selected__info__description">
						{habitacions[selectedHabitacio]?.descripcio}
					</p>
					<button
						className="habitacionsTipus__selected__info__btn"
						onClick={handleReservar}>
						Reservar
					</button>
				</div>
			</div>
		</div>
	);
}
