import React, { useRef, useEffect, useState } from 'react';
 
import { Button, Popover, OverlayTrigger } from 'react-bootstrap';

const Contact = React.forwardRef((props, ref) => {
    const { peopleId, ...popoverProps } = props;
    const [ ready, setReady ] = useState(false);
    const [ data, setData ] = useState([]);

    useEffect(() => {
        fetch(`/people/${peopleId}/contact`)
            .then(res => res.json())
            .then(res => {
                console.log("res", res);
                setData(res);
            })
            .catch(err => console.error("Contact Erqror", err))
            .finally(() => setReady(true));
    }, []);

    return (
    <Popover ref={ref} {...popoverProps}>
        <Popover.Title as="h3">{ window._translations?.['contact.title'] }</Popover.Title>
        <Popover.Content>
        {
            !ready?
            <div className="d-flex align-items-center justify-content-center">
                <div className="spinner-border text-secondary" role="status">
                <span className="sr-only">Loading...</span>
                </div>
            </div>:
            data.length > 0?
            <table className="table">
                <thead></thead>
                <tbody>
                {
                    data.map(item => (
                    <tr key={`contact_${item.id}`}>
                        <td className="text-nowrap">{item.contact_type.name}</td>
                        <td>{item.data}</td>
                    </tr>))                    
                }
                </tbody>
            </table>:
            <h5>{window._translations?.['form.norecord']}</h5>
        }
        </Popover.Content>
    </Popover>)
});

function ContactButton(props){
    const [ show, setShow ] = useState(false);
    const hideTimer = useRef(null);

    useEffect(() => {
        clearTimeout(hideTimer.current);
        if(show){
            hideTimer.current = setTimeout(() => { setShow(false) }, 3000);
        }
    }, [show])

    return (
    <OverlayTrigger
        placement={'bottom'} trigger="click" show={show}
        overlay={(<Contact peopleId={props.peopleId} />)}
    >
        <Button className="btn btn-sm btn-success" type="button" onClick={() => setShow(!show)}>
            <i className="fas fa-phone"></i>
        </Button>
    </OverlayTrigger>)
}

export {
    Contact, 
    ContactButton 
}