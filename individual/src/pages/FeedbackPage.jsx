import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router';

export default function FeedbackPage() {
    const [rating, setRating] = useState(0);
    const [hover, setHover] = useState(0);
    const [comment, setComment] = useState('');
    const [message, setMessage] = useState('');
    const [showForm, setShowForm] = useState(true);
    const [validToken, setValidToken] = useState(true);

    const { token } = useParams();
    const navigate = useNavigate();

    useEffect(() => {
        if (!token) {
            navigate('/');
            return;
        }

        const fetchFeedback = async () => {
            const apiUrl = import.meta.env.DEV
                ? import.meta.env.VITE_DEV_API_URL
                : import.meta.env.VITE_PROD_API_URL;
            const response = await fetch(`${apiUrl}/v2/feedback/${token}`);
            const data = await response.json();

            if (!response.ok || !data.id_reserva) {
                setValidToken(false);
                navigate('/');
            }
        };

        fetchFeedback();
    }, [token, navigate]);

    const handleSubmit = async (e) => {
        e.preventDefault();

        const apiUrl = import.meta.env.DEV
            ? import.meta.env.VITE_DEV_API_URL
            : import.meta.env.VITE_PROD_API_URL;
        const response = await fetch(`${apiUrl}/v2/feedback/submit`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                token,
                estrelles: rating,
                comentari: comment,
            }),
        });

        if (response.ok) {
            setMessage('Gràcies per donar el teu feedback!');
            setShowForm(false);
        } else {
            setMessage('Error enviant el feedback. Intenta-ho de nou.');
        }
    };

    if (!validToken) return null;

    return (
        <div className="feedback-container">
            <h1>Feedback</h1>
            <p>Comparteix la teva experiència a Hotel Sakura</p>

            {showForm ? (
                <form onSubmit={handleSubmit}>
                    <div className="rating">
                        {[1, 2, 3, 4, 5].map((index) => (
                            <button
                                type="button"
                                key={index}
                                className={index <= (hover || rating) ? "on" : "off"}
                                onClick={() => setRating(index)}
                                onMouseEnter={() => setHover(index)}
                                onMouseLeave={() => setHover(rating)}
                            >
                                <span className="material-icons star">star</span>
                            </button>
                        ))}
                    </div>

                    <div className="form-group">
                        <textarea
                            value={comment}
                            onChange={(e) => setComment(e.target.value)}
                            placeholder="Escribe tu comentario aquí..."
                            required
                        />
                    </div>

                    <button type="submit" className="submit-btn">Enviar Feedback</button>
                </form>
            ) : (
                <div>
                    <p>{message}</p>
                    <button onClick={() => navigate('/')} className="submit-btn">
                        Tornar a l&apos;Inici
                    </button>
                </div>
            )}
        </div>
    );
}
