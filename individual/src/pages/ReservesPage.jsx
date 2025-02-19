import React, {useEffect} from 'react';

const homeStyle = {
    //css aquí
};

export default function ReservesPages() {
    useEffect(() => {
        document.title = 'Sakura | Reserves';
    }, []);

    return (
        <div style={homeStyle}>
            <h1>Página Reserves</h1>
        </div>
    );
}
