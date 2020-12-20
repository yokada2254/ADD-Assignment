import React from 'react';

import { Modal } from 'react-bootstrap';

function Wrapper({title, children, show, onClose}){
    return (
    <Modal size="lg" backdrop="static" show={show} onHide={onClose}>
        <Modal.Header closeButton>
            <Modal.Title>{title}</Modal.Title>
        </Modal.Header>
        <Modal.Body className="p-0">
            { children }
        </Modal.Body>
        <Modal.Footer></Modal.Footer>
    </Modal>)
}

export default Wrapper;