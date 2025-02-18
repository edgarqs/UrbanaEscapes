import React, { useEffect } from 'react';

export default function HomePage() {
	useEffect(() => {
		document.title = 'Sakura | Inici';
	  }, []);

	return (
		<h1>Home</h1>
	);
}
