# React + Vite

This template provides a minimal setup to get React working in Vite with HMR and some ESLint rules.

Currently, two official plugins are available:

- [@vitejs/plugin-react](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react/README.md) uses [Babel](https://babeljs.io/) for Fast Refresh
- [@vitejs/plugin-react-swc](https://github.com/vitejs/vite-plugin-react-swc) uses [SWC](https://swc.rs/) for Fast Refresh


## COMO USAR REACT

```
import {Fragment, StrictMode} from 'react';
import {createRoot} from 'react-dom/client';

createRoot(document.querySelector('#root')).render(
	<Fragment>
		<button>Hola</button>
		<button>Hola</button>
	</Fragment>
)
```

`Fragment` permite usar más de un elemento html.

Crear componente bowton con pascual cases leche.

main.jsx:
```
import React from 'react';
import ReactDOM from 'react-dom/client';

import { App } from './components/App';

const root = ReactDOM.createRoot(document.querySelector('#root2'))

root.render(
  <App />
)
```

### Para el CSS:
Usar id no es recomendable, se usa className.