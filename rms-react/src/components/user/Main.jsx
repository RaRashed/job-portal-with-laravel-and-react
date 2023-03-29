import React from 'react';
import Header from './header/Header';
import Category from './categories/Category';
import FeaturedJob from './featured-jobs/FeatuedJob';
import Footer from './footer/Footer';


const Main = () => {
  return (
    <>
    <Header/>
    <Category/>
    <FeaturedJob/>
    <Footer/>
    </>
  )
}

export default Main