import { useEffect, useState } from 'react';

export default function UltimesNoticiesComponent() {
    const [noticies, setNoticies] = useState([]);

    useEffect(() => {
        const fetchNoticies = async () => {
            try {
                const apiUrl = import.meta.env.DEV
                    ? import.meta.env.VITE_DEV_API_URL
                    : import.meta.env.VITE_PROD_API_URL;
                const hotelId = import.meta.env.VITE_HOTEL_ID;
                const response = await fetch(`${apiUrl}/v2/noticies/latest/${hotelId}`);
                const data = await response.json();
                setNoticies(data);
            } catch (error) {
                console.error('Error fetching latest news:', error);
            }
        };

        fetchNoticies();
    }, []);

    return (
        <div className="ultimes-noticies">
            <h3>Últimes Notícies</h3>
            <div className="noticies-grid">
                {noticies.map((noticia) => (
                    <div key={noticia.id} className="noticia-card">
                        <h4>{noticia.titol}</h4>
                        <p>{noticia.descripcio_curta}</p>
                    </div>
                ))}
            </div>
        </div>
    );
}
