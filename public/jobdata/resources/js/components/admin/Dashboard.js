import React, { useState, useEffect } from 'react'
// import styled from 'styled-components'
import Loader from "react-js-loader";
import { Url, PubliUrl } from "../../Config"
import { useTable, usePagination } from "react-table";
import RefreshIcon from '@mui/icons-material/Refresh';
import CircularProgress from '@mui/material/CircularProgress';
import TextField from '@mui/material/TextField';
import Stack from '@mui/material/Stack';
// import Header from './Header'

const Actions = ({ values, props }) => {

    const [sureToDelete, setSureToDelete] = useState(false);
    const [changeVarification, setChangeVarification] = useState(false);

    let cell = values.row.original;
    const makeAction = (userId, action) => {
        let params = {
            userId: userId ? userId : null,
            action: action ? action : null,
        }
        userId && axios.post(`${PubliUrl}/api/actionUser`, params).then(res => {
            props.setAllUsers(res.data.data);
        });
    }

    return (
        <>
            <div>

                {
                    sureToDelete ?
                        <>
                            <label>
                                Are You Sure?
                            </label>
                            <button onClick={() => {
                                makeAction(cell.id, 'delete');
                            }}>Yes</button>
                            <button onClick={() => setSureToDelete(false)}>No</button>
                        </>
                        :
                        <button onClick={() => setSureToDelete(true)}>
                            Delete
                        </button>
                }{
                    // changeVarification ?
                    //     <>
                    //         <label>
                    //             Change to
                    //         </label>
                    //         <button id="active" onClick={() => {
                    //             makeAction(cell.id, 'varifiedYes');
                    //         }}>Active</button>
                    //         <button id="inActive" onClick={() => {
                    //             makeAction(cell.id, 'varifiedNo');
                    //         }}>InActive</button>
                    //         <button onClick={() => setChangeVarification(false)}>X</button>
                    //     </>
                    //     :
                    //     <button onClick={() => setChangeVarification(true)}>
                    //         Varification
                    //     </button>
                }
            </div>
        </>
    );
};

const TableFilter = ({ props }) => {
    const [dataLoading, setDataLoading] = useState(false);

    const clearFilter = () => {
        props.setUserEmail(null);
        props.setUserVarified(null);
        props.setRemoteClick(null);
        let btnFilterByRemote = document.querySelector('input[type=radio][name=filterByVarify]:checked');
        if (btnFilterByRemote) {
            btnFilterByRemote.checked = false;
        }
    }

    dataLoading && setTimeout(() => {
        setDataLoading(false);
    }, 1000);
    return (
        <>
            <div className="main-top_bar">
                <div className="data_entries-result">
                    <div className="header_pagination">
                        <div className="container-fluid">
                            <div className='left_content'>
                                <span>
                                    Showing{" "}
                                    <strong>
                                        {props.currentPage} To {props.totalPages} Entries
                                    </strong>{" "}
                                </span>{" "}
                                <span>
                                    Show
                                    <select
                                        value={props.perPage}
                                        onChange={(e) => {
                                            props.setPerPage(Number(e.target.value));
                                            // props.setPageSize(Number(e.target.value));
                                        }}
                                    >
                                        {[10, 25, 50, 100, 250, 500].map((perPage) => (
                                            <option key={perPage} value={perPage}>
                                                {perPage}
                                            </option>
                                        ))}
                                    </select>
                                    Entries
                                </span>
                                <span>
                                    {!dataLoading ?
                                        <RefreshIcon sx={{ height: '70%' }} onClick={() => {
                                            props.refreshData ? props.setRefreshData(false) : props.setRefreshData(true)
                                            setDataLoading(true);
                                            clearFilter();
                                        }} /> :
                                        <CircularProgress sx={{ height: '30%' }} />
                                    }
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

const DataFilter = ({ props }) => {

    return (
        <div className="user_filter">
            <div id='left-sidebar'>
                <div className='body_part-content'>
                    <div className='filter_wrapper'>

                        <div className='field'>
                            <Stack spacing={1}>
                                <TextField
                                    size="small"
                                    label="User Email"
                                    placeholder="Type 2 charactor"
                                    value={props.userEmail}
                                    onChange={(e) => {
                                        // (e.target.value.length > 1 || e.target.value.length == 0) && props.setUserEmail(e.target.value);
                                        props.setUserEmail(e.target.value);
                                    }}
                                />
                            </Stack>
                        </div>
                        <div className='field'>
                            <div className='remote-wrap'>
                                <label>Varified</label>
                                <Stack spacing={1}>
                                    <div className='checkbox_wrap' >
                                        <label htmlFor="varifiedYes">
                                            <input
                                                type="radio"
                                                name='filterByVarify'
                                                id="varifiedYes"
                                                onClick={(e) => {
                                                    if (props.remoteClick == "yes") {
                                                        e.target.checked = false;
                                                        props.setRemoteClick(null);
                                                        props.setUserVarified(null);
                                                    };
                                                }}
                                                onChange={(e) => {
                                                    props.setRemoteClick("yes");
                                                    props.setUserVarified(true);
                                                }}
                                            /><span className='radiotbtn'></span>
                                            Yes</label>
                                        <label htmlFor="varifiedNo">
                                            <input
                                                type="radio"
                                                name='filterByVarify'
                                                id="varifiedNo"
                                                onClick={(e) => {
                                                    if (props.remoteClick == "no") {
                                                        e.target.checked = false;
                                                        props.setRemoteClick(null);
                                                        props.setUserVarified(null);
                                                    };
                                                }}
                                                onChange={(e) => {
                                                    props.setRemoteClick("no");
                                                    props.setUserVarified(false);
                                                }}
                                            />
                                            <span className='radiotbtn'></span>
                                            No</label>
                                    </div>
                                </Stack>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    );

}

const UserTable = ({ props }) => {

    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        prepareRow,
        page, // Instead of using 'rows', we'll use page,
        // which has only the rows for the active page

        // The rest of these things are super handy, too ;)
        canPreviousPage,
        canNextPage,
        pageOptions,
        pageCount,
        gotoPage,
        nextPage,
        previousPage,
        setPageSize,
        // state: { pageIndex, pageSize },
    } = useTable(
        {
            columns: props.columns,
            data: props.allUsers,
            initialState: {
                pageIndex: 0,
                pageSize: 500,
            },
        },
        usePagination
    );
    // props = {
    // ...props,
    // setPageSize: setPageSize
    //   }
    return (
        <>
            <div className='data_table-section'>
                <div className='responsive_table'>
                    <table {...getTableProps()} id="dataTable">
                        <thead>
                            {headerGroups.map(headerGroup => (
                                <tr {...headerGroup.getHeaderGroupProps()}>
                                    {headerGroup.headers.map(column => (
                                        <th {...column.getHeaderProps()}>{column.render('Header')}</th>
                                    ))}
                                </tr>
                            ))}
                        </thead>
                        <tbody {...getTableBodyProps()}>
                            {page.map((row, i) => {
                                prepareRow(row)
                                return (
                                    <tr {...row.getRowProps()}>
                                        {row.cells.map(cell => {
                                            return <td {...cell.getCellProps()}>{cell.render('Cell')}</td>
                                        })}
                                    </tr>
                                )
                            })}
                        </tbody>
                    </table>
                </div>
                <div className="pagination-section">
                    <button onClick={() => {
                        props.setPageChange(1);
                    }} disabled={props.enPreviousPage}>
                        {"<<"}
                    </button>{" "}
                    <button onClick={() => {
                        props.setPageChange(props.currentPage - 1);
                    }} disabled={props.enPreviousPage}>
                        Previous
                    </button>{" "}
                    <button onClick={() => {
                        props.setPageChange(props.currentPage + 1);
                    }} disabled={props.enNextPage}>
                        Next
                    </button>{" "}
                    <button onClick={() => {
                        props.setPageChange(props.totalPages);
                    }} disabled={props.enNextPage}>
                        {">>"}
                    </button>{" "}
                </div>
            </div>
        </>
    )
}

const Dashboard = () => {
    const [isAdmin, is_admin] = useState(false);
    const [allUsers, setAllUsers] = useState(null)
    const [perPage, setPerPage] = useState(10);
    const [currentPage, setCurrentPage] = useState(null);
    const [pageChange, setPageChange] = useState(null);
    const [refreshData, setRefreshData] = useState(false);
    const [totalPages, setTotalPages] = useState(null);
    const [enPreviousPage, setEnPreviousPage] = useState(null);
    const [enNextPage, setEnNext] = useState(null);
    const [dataLoading, setDataLetloading] = useState(true);

    // 

    const [userEmail, setUserEmail] = useState(null);
    const [userVarified, setUserVarified] = useState(null);
    const [remoteClick, setRemoteClick] = useState(null);

    const columns = [
        {
            Header: 'ID',
            accessor: 'id', // accessor is the "key" in the data
        },
        {
            Header: 'Email',
            accessor: 'email',
        },
        {
            Header: 'Today',
            accessor: 'today_count',
        },
        {
            Header: 'Month',
            accessor: 'month_count',
        },
        {
            Header: 'All Time',
            accessor: 'all_time_count',
        },
        {
            Header: 'Varified',
            accessor: 'varified',
            // Cell: (newValue) => <Actions props={props} values={newValue.cell} />
            Cell: ({ value }) => {
                return (
                    value == 1 ? 'Yes' : 'No'
                );
            }
        },
        {
            Header: 'Join Date',
            accessor: 'created_at',
            Cell: ({ value }) => {
                let today = new Date(value);
                let year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();
                let fecha = day + "-" + month + "-" + year;
                return (
                    fecha
                );
            }
        },
        {
            Header: 'Last Activity',
            accessor: 'updated_at',
            Cell: ({ value }) => {
                let today = new Date(value);
                let year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();
                let fecha = day + "-" + month + "-" + year;
                return (
                    fecha
                );
            }
        },
        {
            Header: 'Action ',
            // accessor: 'id',
            Cell: (newValue) => <Actions props={props} values={newValue.cell} />
        },
    ];

    const params = {
        perPage: perPage,
        userEmail: userEmail,
        userVarified: userVarified,
    };

    useEffect(() => {
        setDataLetloading(true);
        setEnPreviousPage(true);
        setEnNext(true);
        perPage && axios.post(`${PubliUrl}/api/users?page=1`, params)
            .then(res => {
                setDataLetloading(false);
                setCurrentPage(res.data.current_page);
                setTotalPages(res.data.last_page);
                res.data.current_page == 1 ? setEnPreviousPage(true) : setEnPreviousPage(false);
                res.data.current_page == res.data.last_page ? setEnNext(true) : setEnNext(false);
                setAllUsers(res.data.data);
            })
    }, [perPage, userEmail, userVarified, refreshData]);

    // Next/Pre Pagi
    useEffect(() => {
        setDataLetloading(true);
        setEnPreviousPage(true);
        setEnNext(true);
        pageChange && axios.post(`${PubliUrl}/api/users?page=${pageChange}`, params)
            .then(res => {
                setDataLetloading(false);
                setCurrentPage(res.data.current_page);
                setTotalPages(res.data.last_page);
                res.data.current_page == 1 ? setEnPreviousPage(true) : setEnPreviousPage(false);
                res.data.current_page == res.data.last_page ? setEnNext(true) : setEnNext(false);
                setAllUsers(res.data.data);
            })
    }, [pageChange])

    useEffect(() => {
        axios.get(`${PubliUrl}/api/isAdmin`).then(res => {
            is_admin(res.data.isAdmin);
        });
    }, []);

    const props = { allUsers, columns, userEmail, setRefreshData, setPageChange, setAllUsers, setUserEmail, setUserVarified, setRemoteClick, remoteClick, refreshData, currentPage, dataLoading, setPerPage, enNextPage, enPreviousPage, perPage, totalPages }

    if (isAdmin) {
        return (
            <>
                {/* <div className='bizpros-form-section' style={{ background: '#fff' }}>
                    <div className='container' style={{ minHeight: "700px" }}>
                        <TableFilter props={props} />
                        <DataFilter props={props} />
                        {allUsers &&
                            <UserTable props={props} />
                        }
                    </div>
                </div> */}
                <div id="main-content">
                    <div className="main-top_bar">
                        <div className="data_entries-result">
                            <TableFilter props={props} />
                        </div>
                    </div>
                    <div className="main_body-part">
                        <DataFilter props={props} />
                        {allUsers &&
                            <UserTable props={props} />
                        }
                    </div>
                </div>
            </>
        )
    } else {
        return (
            <Loader
                type="spinner-circle"
                bgColor={"#111"}
                title={"box-rotate-x"}
                color={'#FFFFFF'}
                size={100}
            />)
    }
}

export default Dashboard