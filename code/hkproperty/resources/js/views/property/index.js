import React, { useState, useReducer } from 'react';
import PropTypes from 'prop-types';

import { Button } from 'react-bootstrap';

import { SelectedTypes, selectedReducer } from '../search/selected';
import SearchProperty from '../search/property';

function Property({disabled, items}){
    const [showProperties, setShowProperties] = useState(false);
    const [properties, dispatchProperties] = useReducer(selectedReducer, items);

    const propertiesOnClose = properties => {
        setShowProperties(false);
        dispatchProperties({
            type: SelectedTypes.CONCAT,
            item: properties
        });
    }

    return (
    <>
        <div className="card">
            <div className="card-header d-flex justify-content-between align-items-center">
                <h5 className="font-weight-bold">{ __('property.title') }</h5>
            {
                disabled?
                <div></div>:
                <Button size="sm" variant="dark" onClick={() => setShowProperties(true)}>
                    <i className="fas fa-plus mr-2"></i>{ __('form.add') }
                </Button>
            }
            </div>
            <div className="card-body p-0">
            {
                properties.length > 0 &&
                <table className="table table-responsive-md table-dark table-striped m-0">
                    <thead>
                    <tr>
                        <td>{__('estate.type')}</td>
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
                        <td>{P.estate.estate_type.name}<input type="hidden" name="property_id[]" value={P.id} /></td>
                        <td>{P.estate.name}</td>
                        <td className="text-center">{P.block}</td>
                        <td className="text-center">{P.floor}</td>
                        <td className="text-center">{P.flat}</td>
                        <td className="text-center">{P.room}</td>
                        <td className="text-center">{P.gross_size}</td>
                        <td>
                            <Button 
                                size="sm" variant="danger" 
                                onClick={() => dispatchProperties({type: SelectedTypes.DEL, item: P})}
                                disabled={disabled}
                            >
                                <i className="fas fa-trash"></i>
                            </Button>
                        </td>
                    </tr>))
                }
                    </tbody>
                </table>
            }
            </div>
            <div className="card-footer"></div>
        </div>
        <SearchProperty 
            show={showProperties} 
            onClose={propertiesOnClose}
        />
    </>)
}

Property.propTypes = {
    items: PropTypes.array,
    disabled: PropTypes.bool
}

Property.defaultProps = {
    items: [],
    disabled: false
}

export default Property;