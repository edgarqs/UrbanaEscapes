import {useEffect} from 'react';
import HabitacionsComponent from '@components/HabitacionsComponent';
import HeroComponent from '@components/HeroComponent';
import MostrarFeedbacksComponent from '@components/MostrarFeedbacksComponent';

export default function HomePage() {
	useEffect(() => {
		document.title = 'Sakura | Inici';
	}, []);

	return (
		<div>
			<HeroComponent />
			<HabitacionsComponent />
			<MostrarFeedbacksComponent />
		</div>
	);
}
