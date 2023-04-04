import React from 'react';
import Header from './header/Header';
import Category from './categories/Category';
import FeaturedJob from './featured-jobs/FeatuedJob';
import Footer from './footer/Footer';
import Jobs from './jobs/Jobs';


const Main = () => {
  return (
    <>
    <Header/>
    <Category/>
    <FeaturedJob/>
    <Jobs/>
    <Footer/>
    </>
  )
}

export default Main