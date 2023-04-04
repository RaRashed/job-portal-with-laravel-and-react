// import logo from './logo.svg';
// import './App.css';

// function App() {
//   return (
//     <div className="App">
//       <header className="App-header">
//         <img src={logo} className="App-logo" alt="logo" />
//         <p>
//           Edit <code>src/App.js</code> and save to reload.
//         </p>
//         <a
//           className="App-link"
//           href="https://reactjs.org"
//           target="_blank"
//           rel="noopener noreferrer"
//         >
//           Learn React
//         </a>
//       </header>
//     </div>
//   );
// }

// export default App;
import React from 'react';
import { Route, Routes } from 'react-router-dom';
import Student from './pages/Student';
import Addstudent from './pages/Addstudent';
// import Main from "./components/user/Main"

const App = () => {
  return (
    <>
    <Routes>
      <>
      <Route path='/' element= { <Student/> } />
      <Route path='/add-student' element= {<Addstudent/>}></Route>
      </>

</Routes> 
    </>

 )
}

export default App
