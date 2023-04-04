import React from 'react'
import { Link } from 'react-router-dom'
import {useEffect,  useState } from "react"
import axios from 'axios';

const Addstudent = () => {
    // state ={
    //     name: '',
    //     email: '',
    //     phone: '',
    // }
    // handleInput = (e) =>{
    //     this.setState({
    //         [e.target.name] : e.target.value
    //     });
    // }
 const [id,setId] = useState('');
 const [name,setName] = useState("");
 const [email,setEmail] = useState("");
 const [phone,setPhone] = useState("");
  
 useEffect(() =>{
(async () => await Load())();
 },[]);


 async function Load()
 {
  const result =await axios.get(
    "http://127.0.0.1/api/students");
    // setUsers(result.data);
    console.log(result.data);
 }

 async function save(event)
 {
     event.preventDefault();
 try
     {
      await axios.post("http://127.0.0.1:8000/api/save",
     {
       name: name,
       email: email,
       phone: phone
     
     });
       alert("Employee Registation Successfully");
       setId("");
       setName("");
       setEmail("");
       setPhone("");
     
     }
 catch(err)
     {
       alert("User Registation Failed");
     }
}
  
  return (
    <div className='container'>
        <div className='row'>
            <div className='col-md-8'>
                <div className='card'>
                    <div className='card-header'>
                        <h4>Add Student</h4>
                        <Link to={'/'} className='btn btn-primary btn-sm float-end'>BAck</Link>

                    </div>
    <div className='card-body'>
      <from>
      <input type="hidden" name='id'  className="form-control" id="id"
      value={id}   onChange={(event) =>
        {
          setId(event.target.value);
        }
      }

      />
        <div className="mb-3 row">
    <label for="Name" className="col-sm-2 col-form-label">Name</label>
    <div className="col-sm-10">
      <input type="text" name='name'  className="form-control" id="name"
      value={name}   onChange={(event) =>
        {
          setName(event.target.value);
        }
      }

      />
    </div>
  </div>
                        <div className="mb-3 row">
    <label for="staticEmail" className="col-sm-2 col-form-label">Email</label>
    <div className="col-sm-10">
      <input type="text" name='email'  className="form-control" id="email"
         value={email}   onChange={(event) =>
          {
            setEmail(event.target.value);
          }
        } />
    </div>
  </div>
  <div className="mb-3 row">
    <label for="staticEmail" className="col-sm-2 col-form-label">Phone</label>
    <div className="col-sm-10">
      <input type="text" name='phone' className="form-control" id="email"
         value={phone}   onChange={(event) =>
          {
            setPhone(event.target.value);
          }
        } />
    </div>
  </div>
  <div className="mb-3 row">
  <button type='submit' className="btn btn-primary btn-sm" onClick={save}>AddStudent</button>
  </div>

                        </from>
                    </div>

                </div>
            </div>

        </div>
    </div>
  )
}

export default Addstudent