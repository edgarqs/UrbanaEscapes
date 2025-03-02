import {useEffect, useState} from 'react';
import HabitacionsComponent from '@components/HabitacionsComponent';
import HeroComponent from '@components/HeroComponent';
import MostrarFeedbacksComponent from '@components/MostrarFeedbacksComponent';
import BuscadorComponent from '@components/BuscadorComponent';
import UltimesNoticiesComponent from '@components/UltimesNoticiesComponent';

export default function HomePage() {
	const [config, setConfig] = useState(null);

	useEffect(() => {
		document.title = 'Sakura | Inici';

		const hotelId = import.meta.env.VITE_HOTEL_ID;

		const apiUrl = import.meta.env.DEV
			? import.meta.env.VITE_DEV_API_URL
			: import.meta.env.VITE_PROD_API_URL;

		fetch(`${apiUrl}/v2/hotels/${hotelId}/settings`)
			.then((response) => response.json())
			.then((data) => setConfig(data)) 
			.catch((error) =>
				console.error('Error cargando la configuración:', error)
			);
	}, []);

	// Se muestra mientras se carga la configuración
	// TODO: Mejorar con una carga más bonita
	if (!config) {
		return <p>Carregant pàgina...</p>;
	}

	const sectionComponents = {
		hero: <HeroComponent key="hero" />,
		buscador: <BuscadorComponent key="buscador" />,
		habitacions: <HabitacionsComponent key="habitacions" />,
		feedbacks: <MostrarFeedbacksComponent key="feedbacks" />,
		noticies: <UltimesNoticiesComponent key="noticies" />,
	};

	const orderedSections = config.secciones_orden
		.filter((section) => config.secciones_visibles[section])
		.map((section) => sectionComponents[section]);

	return (
		<div className="home">
			{/* Para q siempre se muestre el hero */}
			{sectionComponents.hero}
			{/* El resto de componentes ordenados */}
			{orderedSections}
		</div>
	);
}
