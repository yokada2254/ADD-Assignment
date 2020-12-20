import React, { useState, useReducer, useMemo, useRef } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

import { Form, Button } from 'react-bootstrap';

import { SelectedTypes, selectedReducer } from './selected';

import Wrapper from './wrapper';

function People(props){
    const [items, dispatchItems] = useReducer(selectedReducer, props.items);
    const [list, setList] = useState([]);
    const [page, setPage] = useState(1);
    const [ttlPages, setTtlPages] = useState(1);
    const selectedId = useMemo(() => items.map(item => item.id), [items]);
    const formRef = useRef(null);

    const getPeople = (page = 1) => {
        let fd = new FormData(formRef.current);
        let query = new URLSearchParams(fd);
        query.set('page', page);

        fetch(`/people/?${query}`, {headers: {'Accept': 'application/json'}, method: "GET"})
            .then(res => res.json())
            .then(res => {
                setList(res.data);
                setPage(res.current_page);
                setTtlPages(res.last_page);
                console.log("res", res);
            })
            .catch(err => {
                console.log("People Error: ", err);
            });
    }

    const toggle = (e, item) => {
        let action = {
            type: e.target.checked?SelectedTypes.ADD:SelectedTypes.DEL,
            item
        };
        dispatchItems(action);
    }

    return (
    <Wrapper {...props} title={__('people.title')} onClose={() => props.onClose(items)}>
        <form ref={formRef} className="form mx-2">
            <div className="form-row">
                <div className="form-group col-6">
                    <label>{__('people.name')}</label>
                    <input type="text" className="form-control" name="name" />
                </div>
                <div className="form-group col-6">
                    <label>{__('contact.title')}</label>
                    <input type="text" className="form-control" name="contact" />
                </div>
            </div>
            <div className="form-row d-flex justify-content-center my-2">
                <Button className="btn btn-sm btn-dark mx-2" onClick={() => getPeople()} type="button">
                    <i className="fas fa-search mr-2"></i>
                    {__('form.search')}
                </Button>
                <Button className="btn btn-sm btn-light mx-2">
                    <i className="fas fa-undo mr-2"></i>
                    {__('form.reset')}
                </Button>
            </div>
        </form>
    {
        list.length > 0 &&
        <table className="table table-dark table-striped m-0">
            <thead>
            <tr>
                <td>{__('people.name')}</td>
                <td>{__('people.gender')}</td>
                <td>&nbsp;</td>
            </tr>
            </thead>
            <tbody>
        {
            list.map(item => (
            <tr key={`item_${item.id}`}>
                <td>{item.name}</td>
                <td>{item.gender??'-'}</td>
                <td>
                    <Form.Check 
                        type="checkbox" 
                        onChange={e => toggle(e, item)}
                        checked={selectedId.includes(item.id)}
                    />
                </td>
            </tr>))
        }
            </tbody>
        </table>
    }

    {
        ttlPages > 1 &&
        <div className="form-row">
            <div className="col-12 d-flex align-item-center justify-content-center">
                <div className="input-group input-group-sm">
                    <div className="input-group-prepend">
                        <button className="btn btn-secondary btn-sm" type="button">
                            <i className="fas fa-arrow-left"></i>
                        </button>
                    </div>
                    <select className="form-control" onChange={({target}) => getPeople(target.value)} value={page}>
                    {
                        [...new Array(ttlPages).keys()].map(i => (
                        <option key={i} value={i+1}>{i+1}</option>))
                    }
                    </select>
                    <div className="input-group-append">
                        <button className="btn btn-secondary btn-sm" type="button">
                            <i className="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    }

    </Wrapper>)
}

People.propTypes = {
    show: PropTypes.bool,
    onSelect: PropTypes.func,
    onClose: PropTypes.func,
    items: PropTypes.array
}

People.defaultProps = {
    show: false,
    onSelect: () => {},
    onClose: () => {},
    items: []
}

export default People;