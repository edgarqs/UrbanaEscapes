import {useEffect} from 'react';
import HabitacionsComponent from '@components/HabitacionsComponent';
import HeroComponent from '@components/HeroComponent';
import MostrarFeedbacksComponent from '@components/MostrarFeedbacksComponent';
import BuscadorComponent from '@components/BuscadorComponent';
import UltimesNoticiesComponent from '@components/UltimesNoticiesComponent';

export default function HomePage() {
	useEffect(() => {
		document.title = 'Sakura | Inici';
	}, []);

	return (
		<div className='home'>
			<HeroComponent />
			<BuscadorComponent />
			<HabitacionsComponent />
			<MostrarFeedbacksComponent />
			<UltimesNoticiesComponent />
		</div>
	);
}
