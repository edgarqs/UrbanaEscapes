import React, {useEffect} from 'react';
import HabitacionsComponent from '@components/HabitacionsComponent';
import HeroComponent from '@components/HeroComponent';

export default function HomePage() {
	useEffect(() => {
		document.title = 'Sakura | Inici';
	}, []);

	return (
		<div>
			<HeroComponent />
			<HabitacionsComponent />
		</div>
	);
}
