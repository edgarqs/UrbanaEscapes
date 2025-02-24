import { useState, useEffect, useRef } from 'react';

export default function FeedbacksComponent() {
  const [feedbacks, setFeedbacks] = useState([]);
  const [page, setPage] = useState(1);
  const [loading, setLoading] = useState(false);
  const [hasMore, setHasMore] = useState(true);
  const containerRef = useRef(null);

  const apiUrl = import.meta.env.VITE_DEV_API_URL;
  const tokenHotel = import.meta.env.VITE_HOTEL_ID;

  const fetchFeedbacks = async (page) => {
    setLoading(true);
    try {
      const response = await fetch(`${apiUrl}/v2/feedbacks/${tokenHotel}?page=${page}`);
      const data = await response.json();

      // Evitar duplicados usando un Set
      const newFeedbacks = data.filter(
        (newFeedback) => !feedbacks.some((existingFeedback) => existingFeedback.id === newFeedback.id)
      );

      if (newFeedbacks.length > 0) {
        setFeedbacks((prevFeedbacks) => [...prevFeedbacks, ...newFeedbacks]);
      } else {
        setHasMore(false); // No hay más feedbacks para cargar
      }
    } catch (error) {
      console.error('Error fetching feedbacks:', error);
    } finally {
      setLoading(false);
    }
  };

  // Cargar los primeros feedbacks al montar el componente
  useEffect(() => {
    setFeedbacks([]); // Resetear los feedbacks al inicio
    setPage(1); // Resetear la página al inicio
    setHasMore(true); // Resetear el estado de "hasMore"
    fetchFeedbacks(1); // Cargar la primera página
  }, [apiUrl, tokenHotel]); // Resetear si cambian la API o el token

  // Cargar más feedbacks cuando cambia la página
  useEffect(() => {
    if (page > 1) {
      fetchFeedbacks(page);
    }
  }, [page]);

  // Manejar el scroll horizontal
  useEffect(() => {
    const container = containerRef.current;

    const handleScroll = () => {
      if (
        container.scrollLeft + container.clientWidth >= container.scrollWidth - 100 &&
        !loading &&
        hasMore
      ) {
        setPage((prevPage) => prevPage + 1); // Cargar la siguiente página
      }
    };

    container.addEventListener('scroll', handleScroll);
    return () => {
      container.removeEventListener('scroll', handleScroll);
    };
  }, [loading, hasMore]);

  return (
    <div className="feedbacks">
      <h2 className="margin-top feedbacks__title">Feedbacks dels clients</h2>

      <div
        ref={containerRef}
        className="feedbacks__list"
        style={{ overflowX: 'auto', whiteSpace: 'nowrap' }}
      >
        {feedbacks.map((feedback) => (
          <div
            key={feedback.id}
            className="feedbacks__item"
            style={{ display: 'inline-block', margin: '10px', padding: '10px', border: '1px solid #ccc' }}
          >
            <div className="feedbacks__item__stars">ID: {feedback.id}</div>
            <div className="feedbacks__item__stars">Estrelles: {feedback.estrelles}</div>
            <div className="feedbacks__item__comment">Comentari: {feedback.comentari}</div>
          </div>
        ))}
        {loading && <div className="feedbacks__loading">Carregant més feedbacks...</div>}
        {!hasMore && <div className="feedbacks__no-more">No hi ha més feedbacks per mostrar.</div>}
      </div>
    </div>
  );
}