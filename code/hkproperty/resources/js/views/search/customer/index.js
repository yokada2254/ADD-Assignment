import React, { useState, useRef } from 'react';


import Wrapper from '../wrapper';
import SearchForm from './form';


function Customer(props){
    const formRef = useRef(null);
    const [list, setList] = useState([]);

    const getCustomer = (page = 1) => {
        let fd = new FormData(formRef.current);
        let query = new URLSearchParams(fd);
        query.set("page", page);
        query.set("submit", 1);

        fetch(`/customer?${query}`, {method: "GET", headers: {'Accept': 'application/json'}})
            .then(res => res.json())
            .then(res => {
                setList(res.data);
            });
    }

    const onClose = item => {
        setList([]);
        props.onClose(item);
    }

    return (
    <Wrapper {...props} title={__('customer.title')} onClose={onClose}>
    {
        list.length == 0?
        <SearchForm formRef={formRef} submit={getCustomer}></SearchForm>:
        <div className="container">
            <div className="text-center my-2">
                <div className="btn btn-sm btn-light" onClick={() => setList([])}>{__('form.cancel')}</div>
            </div>
        {
            list.map(item => (
            <div className="row my-1" key={item.id}>
                <div className="col-10">{item.people.map(p => p.name).join(", ")}</div>
                <div className="col-auto col-2">
                    <div className="btn-group">
                        <div className="btn btn-sm btn-success">
                            <i className="fas fa-eye"></i>
                        </div>
                        <div className="btn btn-sm btn-dark" onClick={() => onClose(item)}>
                            <i className="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>))
        }
        </div>
    }
    </Wrapper>)
}

export default Customer;