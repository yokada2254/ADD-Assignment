import React, { useState, useReducer } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';

import { Button, OverlayTrigger } from 'react-bootstrap';

import { SelectedTypes, selectedReducer } from '../search/selected';
import SearchPeople from '../search/people';
import { ContactButton } from './contact';

function People({title, disabled, items}){
    const [showSearch, setShowSearch] = useState(false);
    const [people, dispatchPeople] = useReducer(selectedReducer, items);

    const onClose = people => {
        dispatchPeople({
            type: SelectedTypes.CONCAT,
            item: people
        })
        setShowSearch(false);
    }

    return (
    <>
    <div className="card">
        <div className="card-header d-flex justify-content-between align-items-center">
            <h5 className="font-weight-bold">{title}</h5>
        {
            disabled?
            <div></div>:
            <Button size="sm" variant="dark" onClick={() => setShowSearch(true)}>
                <i className="fas fa-plus mr-2"></i>
                { window.__('form.add') }
            </Button>
        }
        </div>
        <div className="card-body p-0">
        {
            people.length > 0 &&
            <table className="table table-dark table-stiped m-0">
                <colgroup>
                    <col width="*" />
                    <col width="*" />
                    <col width="90" />
                </colgroup>
                <thead>
                <tr>
                    <td>{window.__('people.name')}</td>
                    <td>{window.__('people.gender')}</td>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
            {
                people.map(item => (
                <tr key={`item_${item.id}`}>
                    <td>{item.name}<input type="hidden" name="people_id[]" value={item.id} /></td>
                    <td>{item.gender??'-'}</td>
                    <td>
                        <div className="btn-group">
                            <ContactButton peopleId={item.id} />
                        {
                            !disabled &&
                            <Button size="sm" variant="danger" onClick={() => dispatchPeople({type: SelectedTypes.DEL, item})} disabled={disabled}>
                                <i className="fas fa-trash"></i>
                            </Button>
                        }
                        </div>
                    </td>
                </tr>))
            }
                </tbody>
            </table>
        }
        </div>
        <div className="card-footer"></div>
    </div>
    <SearchPeople show={showSearch} onClose={onClose} />
    </>);
}

People.propTypes = {
    items: PropTypes.array,
    disabled: PropTypes.bool
}

People.defaultProps = {
    items: [],
    disabled: false,
    title: __('people.title'),
    limit: false
}

export default People;

document.querySelectorAll("people").forEach(dom => {
    let props = Object.assign({}, dom.dataset);
    if(!!props.items) props.items = JSON.parse(props.items);
    if(!!props.disabled) props.disabled = props.disabled == "true";
    
    ReactDOM.render(<People {...props} />, dom);
});