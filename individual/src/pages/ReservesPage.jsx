import {useEffect, useState} from 'react';
import {useLocation} from 'react-router';
import BuscadorComponent from '@components/BuscadorComponent';

//? Fotos de las habitaciones
import estandarImg from '@/assets/habitacio-estandar.avif';
import deluxeImg from '@/assets/habitacio-deluxe.avif';
import suiteImg from '@/assets/habitacio-suite.avif';
import adaptadaImg from '@/assets/habitacio-adaptada.avif';

export default function ReservesPage() {
	const location = useLocation();
	const queryParams = new URLSearchParams(location.search);

	const dataEntrada = queryParams.get('dataEntrada') || '';
	const dataSortida = queryParams.get('dataSortida') || '';
	const numPersones = queryParams.get('numPersones') || 1;

	const [habitacions, setHabitacions] = useState([]);

	useEffect(() => {
		document.title = 'Sakura | Reserves';

		const fetchHabitacions = async () => {
			try {
				const api = import.meta.env.DEV
					? import.meta.env.VITE_DEV_API_URL
					: import.meta.env.VITE_PROD_API_URL;
				const codiHotel = import.meta.env.VITE_HOTEL_ID;
				const response = await fetch(
					`${api}/v2/habitacions/${codiHotel}/disponibles?data_entrada=${dataEntrada}&data_sortida=${dataSortida}&capacitat=${numPersones}`
				);
				const data = await response.json();
				setHabitacions(data);
			} catch (error) {
				console.error(
					'Error al buscar habitaciones disponibles:',
					error
				);
			}
		};

		if (dataEntrada && dataSortida && numPersones) {
			fetchHabitacions();
		}
	}, [dataEntrada, dataSortida, numPersones]);

	return (
		<div>
			<BuscadorComponent />
			{habitacions.length > 0 && (
				<div>
					{habitacions.map((habitacio) => (
						<div key={habitacio.id}>
							<div>
								<img
									src={getHabitacioImage(habitacio.tipus)}
									alt={habitacio.tipus}
								/>
							</div>
							<div>
								<h3>{habitacio.tipus}</h3>
								<p>Preu Total: {habitacio.preuTotal} €</p>
								<button>Sel·lecionar</button>
							</div>
						</div>
					))}
				</div>
			)}
		</div>
	);
}

function getHabitacioImage(tipus) {
	switch (tipus) {
		case 'Estandar':
			return estandarImg;
		case 'Deluxe':
			return deluxeImg;
		case 'Suite':
			return suiteImg;
		case 'Adaptada':
			return adaptadaImg;
		default:
			return estandarImg;
	}
}
