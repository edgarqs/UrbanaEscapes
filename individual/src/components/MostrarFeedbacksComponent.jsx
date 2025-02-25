import {useState, useEffect} from 'react';

export default function FeedbacksComponent() {
	const [feedbacks, setFeedbacks] = useState([]); // Se guardan los feedbacks
	const [page, setPage] = useState(1); // Guarda la pag actual (scroll = cambio de página)
	const [loading, setLoading] = useState(false); // TODO: Chapuza, solucionar - Evita q carguen datos duplicados

	useEffect(() => {
		const getFeedbacks = async () => {
			if (loading) return; // Si está cargando no hace nada
			setLoading(true);

			try {
				const response = await fetch(
					`${import.meta.env.VITE_DEV_API_URL}/v2/feedbacks/${import.meta.env.VITE_HOTEL_ID}?page=${page}`
				);
				const data = await response.json();

				// TODO: Chapuza, solucionar - Evita q carguen datos duplicados
				const existingIds = new Set(
					feedbacks.map((feedback) => feedback.id)
				);
				const newFeedbacks = data.filter(
					(feedback) => !existingIds.has(feedback.id)
				);

				setFeedbacks([...feedbacks, ...newFeedbacks]);
			} catch (error) {
				console.error('Error al cargar los feedbacks:', error);
			} finally {
				setLoading(false);
			}
		};

		getFeedbacks();
	}, [page]); // Se ejecuta cada vez q cambia la página (scroll)

	const handleScroll = (e) => {
		const container = e.target;

		if (
			container.scrollLeft + container.clientWidth >=
				container.scrollWidth &&
			!loading
		) {
			setPage(page + 1);
		}
	};

	// Funció per limitar el texto a 100 caracteres
	const limitarTexto = (texto) => {
		if (texto.length > 100) {
			return texto.slice(0, 100) + '...';
		}
		return texto;
	};

	return (
		<div className="feedbacks-component">
			<h2 className="feedbacks-component__title font-primary">
				Qué pensen els nostres clients?
			</h2>
			<div
				className="feedbacks-container"
				onScroll={handleScroll}>
				{feedbacks.map((feedback) => (
					<div
						key={feedback.id}
						className="feedback-item">
						<div>
							{[...Array(feedback.estrelles)].map((_, index) => (
								<span
									key={index}
									className="material-icons star">
									star
								</span>
							))}
						</div>
						<div className="feedback-habitacio">
							Habitació {feedback.tipus_habitacio}
						</div>
						<div className="feedback-comment">
							{limitarTexto(feedback.comentari)}{' '}
						</div>
					</div>
				))}
			</div>
		</div>
	);
}
