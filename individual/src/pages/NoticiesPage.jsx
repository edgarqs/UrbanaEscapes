import {useEffect, useState} from 'react';

export default function NoticiesPages() {
    const [noticies, setNoticies] = useState([]);

    // Para saber si es desarrollo o prod
    const apiUrl = import.meta.env.DEV
        ? import.meta.env.VITE_DEV_API_URL
        : import.meta.env.VITE_PROD_API_URL;

    const fotoUrl = import.meta.env.DEV
        ? import.meta.env.VITE_DEV_STORAGE_URL
        : import.meta.env.VITE_PROD_STORAGE_URL;

    useEffect(() => {
        document.title = 'Sakura | Notícies';

        fetch(`${apiUrl}/v2/noticies/${import.meta.env.VITE_HOTEL_ID}`)
            .then((response) => response.json())
            .then((data) => setNoticies(data));
    }, [apiUrl]);

    return (
        <div className="noticies">
            <h1 className="noticies__title">Notícies</h1>
            {noticies.length === 0 ? (
                <p className="noticies__no-news">
                    No hi han notícies per mostrar.
                </p>
            ) : (
                noticies.map((noticia) => (
                    <div
                        key={noticia.id}
                        className="noticies__card">
                        <h2 className="noticies__card-title">
                            {noticia.titol}
                        </h2>
                        <p className="noticies__card-description">
                            {noticia.descripcio_llarga}
                        </p>

                        <div className="noticies__card-photos">
                            {noticia.fotos.length > 0 &&
                                noticia.fotos.map((foto) => (
                                    <img
                                        key={foto.id}
                                        className="noticies__card-photo"
                                        src={`${fotoUrl}/storage/noticies/${foto.foto}`}
                                        alt={`Foto de la noticia ${noticia.id}`}
                                    />
                                ))}
                        </div>
                    </div>
                ))
            )}
        </div>
    );
}
