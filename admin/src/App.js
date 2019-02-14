import React from 'react';
import authProvider from './authProvider';
import Admin from './Admin';

const App = () => (
    <Admin authProvider={authProvider}>
        ...
    </Admin>
);

export default () => App();
