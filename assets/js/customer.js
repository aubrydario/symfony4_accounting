import React from 'react';
import ReactDom from 'react-dom';
import Sidebar from "./components/sidebar";

class App extends React.Component {
    constructor() {
        super();

        this.state = {
            user: []
        }
    }

    componentDidMount() {
        fetch('/api/activeUser')
            .then(response => response.json())
            .then(user => {
                this.setState({
                    user: user[0]
                });
            });
    }

    render() {
        return (
            <Sidebar username={this.state.user.username}/>
        );
    }
}

ReactDom.render(<App />, document.getElementById('root'));