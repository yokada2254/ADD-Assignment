import React, { useState, useReducer, useMemo, useEffect, useRef } from 'react';
import PropTypes from 'prop-types';

import { Button, Form} from 'react-bootstrap';

import Wrapper from './wrapper';
import { SelectedTypes, selectedReducer } from './selected';
import PropertyFields from '../../components/PropertyFields';
import Pages from '../../components/Pages';

function Property(props){
    const [properties, setProperties] = useState([]);
    const [selected, dispatchSelected] = useReducer(selectedReducer, []);
    const [noRecord, setNoRecord] = useState(false);
    const selectedId = useMemo(() => selected.map(item => item.id), [selected]);
    const [resetId, setResetIds] = useState(0);
    const formRef = useRef(null);

    const [currentPage, setCurrentPage] = useState(0);
    const [lastPage, setLastPage] = useState(0);

    useEffect(() => {
        if(!props.show){
            dispatchSelected({type: SelectedTypes.CLEAR})
        }
    }, [props.show])

    const getProperties = (page = 1) => {
        let fd = new FormData(formRef.current);
        let query = new URLSearchParams(fd);
        query.set("page", page);

        fetch(`/property?${query}`,  {headers: {'Accept': 'application/json'}, method: "GET"})
            .then(response => {
                if(response.status == 200){
                    return response.json();
                }else{
                    console.log("Something wrong.", res);
                }
            })
            .then(res => {
                setProperties(res.data);
                setCurrentPage(res.current_page);
                setLastPage(res.last_page > 1?res.last_page:0);
                setNoRecord(res.data.length == 0);
            })
            .catch(err => {
                console.log("Error", err);
            });
    }

    const onClose = () => props.onClose(selected)

    const toggle = (e, item) => {
        let action = {type: e.target.checked?SelectedTypes.ADD:SelectedTypes.DEL, item };
        dispatchSelected(action);
    }

    const reset = () => {
        setProperties([]);
        dispatchSelected({type: SelectedTypes.CLEAR});
        setNoRecord(false);
        setResetIds(Date.now());
    }

    return (
    <Wrapper {...props} title={window.__('property.title')} onClose={onClose} >
        <form ref={formRef} className="form mx-2 py-2" onSubmit={e => e.preventDefault()}>
            <div className={`collapse ${properties.length == 0?'show':''}`}>
                <PropertyFields reset={resetId} />
            </div>

            <div className="form-row d-flex justify-content-center my-2">
            {
                properties.length > 0?
                <Button className="btn btn-sm btn-dark mx-2" onClick={() => setProperties([])} type="button">
                    <i className="fas fa-times mr-2"></i>
                    {window.__('form.cancel')}
                </Button>:
                <>
                <Button className="btn btn-sm btn-dark mx-2" onClick={() => getProperties()} type="button">
                    <i className="fas fa-search mr-2"></i>
                    {window.__('form.search')}
                </Button>
                <Button className="btn btn-sm btn-light mx-2" onClick={reset} type="button">
                    <i className="fas fa-undo mr-2"></i>
                    {window.__('form.reset')}
                </Button>
                </>
            }
            </div>
        </form>
    {
        properties.length > 0 &&
        <table className="table table-dark table-striped m-0">
            <thead>
            <tr>
                <td>{__('estate.name')}</td>
                <td>{__('property.block')}</td>
                <td>{__('property.floor')}</td>
                <td>{__('property.flat')}</td>
                <td>{__('property.room')}</td>
                <td>{__('property.gross_size')}</td>
                <td>&nbsp;</td>
            </tr>
            </thead>
            <tbody>
        {
            properties.map(P => (
            <tr key={`property_${P.id}`}>
                <td>{P.estate.name}</td>
                <td>{P.block}</td>
                <td>{P.floor}</td>
                <td>{P.flat}</td>
                <td>{P.room}</td>
                <td>{P.gross_size}</td>
                <td>
                    <Form.Check 
                        type="checkbox" 
                        onChange={e => toggle(e, P)}
                        checked={selectedId.includes(P.id)}
                    />
                </td>
            </tr>))
        }
            </tbody>
        </table>
    }
    {
        noRecord &&
        <div className="d-flex align-items-center justify-content-center">
            <h1 className="font-weight-bold">{window.__('form.norecord')}</h1>
        </div>
    }
    
    {
        lastPage > 1 &&
        <Pages updateFunc={getProperties} {...{currentPage, lastPage}} />
    }
    </Wrapper>)
}

Property.propTypes = {
    show: PropTypes.bool,
    onSelect: PropTypes.func,
    onClose: PropTypes.func
}

Property.defaultProps = {
    onSelect: () => {},
    onClose: () => {}
}

export default Property;