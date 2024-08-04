// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract SoulboundToken {
    struct SBT {
        bytes32 documentHash;
        bytes32 documentID;
        uint256 timestamp;
        address notary;
    }

    mapping(bytes32 => SBT) public sbtRegistry;

    event SBTIssued(bytes32 indexed documentHash, bytes32 indexed documentID, uint256 timestamp, address indexed notary);

    function issueSBT(bytes32 documentHash, bytes32 documentID, address notary) public {
        require(sbtRegistry[documentHash].timestamp == 0, "SBT already exists");

        SBT memory newSBT = SBT({
            documentHash: documentHash,
            documentID: documentID,
            timestamp: block.timestamp,
            notary: notary
        });

        sbtRegistry[documentHash] = newSBT;

        emit SBTIssued(documentHash, documentID, block.timestamp, notary);
    }

    function verifySBT(bytes32 documentHash) public view returns (bool, SBT memory) {
        SBT memory sbt = sbtRegistry[documentHash];
        if (sbt.timestamp != 0) {
            return (true, sbt);
        } else {
            return (false, SBT({documentHash: 0, documentID: 0, timestamp: 0, notary: address(0)}));
        }
    }
}
