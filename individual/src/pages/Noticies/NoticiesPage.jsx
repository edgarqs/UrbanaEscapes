import React, {useEffect} from 'react';

const homeStyle = {
	//css aquí
};

export default function NoticiesPages() {
	useEffect(() => {
		document.title = 'Sakura | Notícies';
	}, []);

	return (
		<div style={homeStyle}>
			<h1>Página Notícies</h1>
		</div>
	);
}
