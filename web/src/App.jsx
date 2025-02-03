import './css/components/App.css';
import {TwitterFollowCard} from './components/TwitterFollowCard';

export function App() {
	return (
		<section className="App">
			<TwitterFollowCard
				userName="midudev"
				name="Miguel Angel Duran"
			/>
			<TwitterFollowCard
				userName="rickyedit"
				name="Rickyedit"
			/>
		</section>
	);
}
