import React from 'react'
import { Link } from 'react-router-dom'

const Student = () => {
  return (
    <div className='container'>
        <div className='row'>
            <div className='col-md-12'>
                <div className='card'>
                    <div className='card-header'>
                        <h4>Student data</h4>
                        <Link to={'add-student'} className='btn btn-primary btn-sm float-end'>Add Student</Link>

                    </div>
                    <div className='card-body'>
                        
                    </div>

                </div>
            </div>

        </div>
    </div>
  )
}

export default Student